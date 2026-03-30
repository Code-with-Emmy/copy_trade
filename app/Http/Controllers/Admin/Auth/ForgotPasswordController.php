<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Actions\Fortify\PasswordValidationRules;
use App\Http\Controllers\Controller;
use App\Mail\NewNotification;
use App\Models\Admin;
use App\Models\Settings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ForgotPasswordController extends Controller
{
    use PasswordValidationRules;

    public function forgotPassword(): View
    {
        return view('auth.admin-forgot-password', [
            'settings' => Settings::query()->find(1),
        ]);
    }

    public function sendPasswordRequest(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email|exists:admins,email',
        ]);

        $admin = Admin::query()->where('email', $request->string('email')->toString())->firstOrFail();
        $token = (string) random_int(100000, 999999);

        Cache::put($this->cacheKey($admin->email), [
            'token' => $token,
        ], now()->addMinutes(15));

        $message = "This is your admin password reset token: {$token}. It expires in 15 minutes. Ignore this email if you did not request a reset.";

        Mail::to($admin->email)->send(new NewNotification(
            $message,
            'Admin Password Reset Request',
            $admin->name ?: 'Administrator'
        ));

        return redirect()
            ->route('resetview', $admin->email)
            ->with('success', 'We sent a reset token to your admin email address.');
    }

    public function resetPassword(string $email): RedirectResponse|View
    {
        $admin = Admin::query()->where('email', $email)->first();

        if (! $admin) {
            return redirect()->route('adminloginform')->with('error', 'Admin account not found.');
        }

        return view('auth.admin-reset-pass', [
            'email' => $email,
            'settings' => Settings::query()->find(1),
        ]);
    }

    public function validateResetPasswordToken(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email|exists:admins,email',
            'token' => 'required|string|size:6',
            'password' => $this->passwordRules(),
        ]);

        $admin = Admin::query()->where('email', $request->string('email')->toString())->firstOrFail();
        $resetState = Cache::get($this->cacheKey($admin->email));

        if (! is_array($resetState) || ($resetState['token'] ?? null) !== $request->string('token')->toString()) {
            return back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->with('message', 'Invalid or expired reset token.');
        }

        $admin->forceFill([
            'password' => Hash::make($request->string('password')->toString()),
        ])->save();

        Cache::forget($this->cacheKey($admin->email));

        return redirect()
            ->route('adminloginform')
            ->with('success', 'Password reset successful. You can now log in.');
    }

    private function cacheKey(string $email): string
    {
        return 'admin_password_reset:' . sha1(strtolower($email));
    }
}
