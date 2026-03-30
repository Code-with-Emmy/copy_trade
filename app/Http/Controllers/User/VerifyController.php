<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\KycApplicationRequest;
use App\Mail\NewNotification;
use App\Models\Kyc;
use App\Models\Settings;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;

class VerifyController extends Controller
{
    //
    public function verifyaccount(KycApplicationRequest $request)
    {
        try {
            $user = Auth::user();

            if ($user->account_verify === 'Verified') {
                return redirect()->route('account.verify')
                    ->with('info', 'Your account is already verified.');
            }

            if ($user->account_verify === 'Under review') {
                return redirect()->route('account.verify')
                    ->with('info', 'Your previous verification submission is still under review.');
            }

            $documentWhitelist = ['jpeg', 'jpg', 'png', 'pdf'];
            $selfieWhitelist = ['jpeg', 'jpg', 'png'];

            // filter front of document upload
            $frontimg = $request->file('frontimg');
            $backimg = $request->file('backimg');
            $faceimg = $request->file('face_img');

            if (!$frontimg || !$frontimg->isValid() || !$backimg || !$backimg->isValid() || !$faceimg || !$faceimg->isValid()) {
                return redirect()->back()
                    ->with('message', 'One or more files were not uploaded correctly. Please try again with smaller files.');
            }

            $backimgExtention = strtolower($backimg->extension());
            $frontimgExtention = strtolower($frontimg->extension());
            $faceimgExtention = strtolower($faceimg->extension());

            if (!in_array($frontimgExtention, $documentWhitelist, true) ||
                !in_array($backimgExtention, $documentWhitelist, true) ||
                !in_array($faceimgExtention, $selfieWhitelist, true)) {
                return redirect()->back()
                    ->with('message', 'Unsupported file type uploaded. Use JPEG/JPG/PNG for selfie and JPEG/JPG/PNG/PDF for ID documents.');
            }

            // upload documents to storage
            $frontimgPath = $frontimg->store('uploads', 'public');
            $backimgPath = $backimg->store('uploads', 'public');
            $faceimgPath = $faceimg->store('uploads', 'public');

            $kycColumns = Schema::getColumnListing('kycs');
            $payload = array_filter([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone_number,
                'phone_number' => $request->phone_number,
                'dob' => $request->dob,
                'ssn' => $request->filled('ssn') ? $request->ssn : 'Not provided',
                'social_media' => $request->social_media ?: 'Not provided',
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
                'document_type' => $request->document_type,
                'id_type' => $request->document_type,
                'frontimg' => $frontimgPath,
                'backimg' => $backimgPath,
                'face_img' => $faceimgPath,
                'status' => 'Under review',
                'user_id' => $user->id,
            ], fn ($value) => $value !== null);

            $kyc = Kyc::create(array_intersect_key($payload, array_flip($kycColumns)));


            $userUpdates = User::filterSchemaAttributes([
                'kyc_id' => $kyc->id,
                'account_verify' => 'Under review',
            ]);

            if (!empty($userUpdates)) {
                User::where('id', $user->id)->update($userUpdates);
            }

            $settings = Settings::find(1);
            if ($settings) {
                $message = "This is to inform you that $user->name just submitted a request for KYC(identity verification), please login your admin account to review and take neccessary action.";
                $subject = "Identity Verification Request from $user->name";
                $url = config('app.url') . '/admin/dashboard/kyc';

                try {
                    Mail::to($settings->contact_email)->send(new NewNotification($message, $subject, 'Admin', $url));
                } catch (\Exception $e) {
                    \Log::error('Failed to send KYC verification notification email. User: ' . $user->name . ' (' . $user->email . '), KYC ID: ' . $kyc->id . '. Error: ' . $e->getMessage());
                }
            } else {
                \Log::warning('Settings with ID 1 not found. KYC email notification skipped.');
            }

            return redirect()->back()->with('success', 'Action Sucessful! Please wait while we verify your application. You will receive an email regarding the status of your application.');
        } catch (\Throwable $e) {
            \Log::error('KYC Submission Error: ' . $e->getMessage());
            return redirect()->back()->with('message', 'Error: ' . $e->getMessage());
        }
    }
}
