<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    public function sendLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = DB::table('users')->where('email', $request->email)->first();
        $admin = DB::table('admins')->where('email', $request->email)->first();

        if (!$user && !$admin) {
            return back()->withErrors(['email' => 'Email not found in our records.']);
        }

        $tokenPayload = $request->email . '|' . now()->addHour()->timestamp;
        $token = rtrim(strtr(base64_encode($tokenPayload), '+/', '-_'), '=');
        $link = url('/reset-password-form?token=' . urlencode($token));

        $message = "Click the link below to reset your password:\n\n$link";

       Mail::html("
    <p>Hi,</p>
    <p>Click the button below to reset your password:</p>
    <p>
        <a href='$link' style='
            display: inline-block;
            padding: 12px 24px;
            background-color: #4CAF50;
            color: #ffffff;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            font-size: 16px;
        '>Reset Password</a>
    </p>
    <p>If you didn’t request a password reset, please ignore this email.</p>
    <p>– ARICC Team</p>
", function ($msg) use ($request) {
    $msg->to($request->email)
        ->subject('Reset Your Password');
});


        return back()->with('success', 'Password reset link has been sent to your email.');
    }

    public function showResetForm(Request $request)
    {
        $token = $request->query('token');

        if (!$token) {
            return redirect()->route('login')->withErrors(['Invalid token']);
        }

        $decoded = base64_decode(strtr($token, '-_', '+/'));

        if (!$decoded || !str_contains($decoded, '|')) {
            return redirect()->route('login')->withErrors(['Invalid token format.']);
        }

        [$email, $expiresAt] = explode('|', $decoded);

        if (Carbon::now()->timestamp > (int)$expiresAt) {
            return redirect()->route('login')->withErrors(['Token has expired.']);
        }

        return view('reset_password', ['email' => $email, 'token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
            'token' => 'required'
        ]);

        $decoded = base64_decode(strtr($request->token, '-_', '+/'));

        if (!$decoded || !str_contains($decoded, '|')) {
            return back()->withErrors(['Invalid token format.']);
        }

        [$emailFromToken, $expiresAt] = explode('|', $decoded);

        if ($emailFromToken !== $request->email || Carbon::now()->timestamp > (int)$expiresAt) {
            return back()->withErrors(['Invalid or expired token.']);
        }

        $hashed = Hash::make($request->password);

        $updated = DB::table('users')->where('email', $emailFromToken)->update([
            'password' => $hashed
        ]);

        if (!$updated) {
            $updated = DB::table('admins')->where('email', $emailFromToken)->update([
                'password' => $hashed
            ]);
        }

        return $updated
            ? redirect()->route('login')->with('success', 'Password has been reset!')
            : back()->withErrors(['email' => 'Account not found.']);
    }
}
