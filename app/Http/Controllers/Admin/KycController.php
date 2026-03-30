<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\NewNotification;
use App\Models\Kyc;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class KycController extends Controller
{
    public function processKycPage()
    {
        return redirect()
            ->route('kyc')
            ->with('message', 'Open a KYC application from the review queue before processing it.');
    }

    public function processKyc(Request $request)
    {
        $application = Kyc::find($request->kyc_id);

        if (!$application) {
            return redirect()
                ->route('kyc')
                ->with('message', 'The selected KYC application could not be found.');
        }

        $user = User::where('id', $application->user_id)->first();

        if (!$user) {
            return redirect()
                ->route('kyc')
                ->with('message', 'The user attached to this KYC application could not be found.');
        }

        // will use API key
        if ($request->action == 'Accept') {
            User::where('id', $user->id)
                ->update([
                    'account_verify' => 'Verified',
                ]);
            $application->status = "Verified";
            $application->save();
        } else {
            if (Storage::disk('public')->exists($application->frontimg) and Storage::disk('public')->exists($application->backimg)) {
                Storage::disk('public')->delete($application->frontimg);
                Storage::disk('public')->delete($application->backimg);
            }

            // Update the user verification status
            $user->account_verify = 'Rejected';
            $user->save();
            // delete the application form database so user can resubmit application
            $application->delete();
        }

        try {
            Mail::to($user->email)->send(new NewNotification($request->message, $request->subject, $user->name));
        } catch (\Throwable $e) {
            \Log::error('Failed to send KYC status notification email to user. User: ' . $user->name . ' (' . $user->email . '), KYC ID: ' . $application->id . ', Action: ' . $request->action . ', Subject: ' . $request->subject . '. Error: ' . $e->getMessage());
        }

        return redirect()->route('kyc')->with('success', 'Action Sucessful!');
    }
}
