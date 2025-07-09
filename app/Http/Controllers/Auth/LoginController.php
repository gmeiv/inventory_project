<?php


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Try user login (default guard)
        if (Auth::guard('web')->attempt($credentials)) {
            return redirect()->intended('/user.dashboard');
        }

        // Try admin login (admin guard)
        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->intended('/admin.dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ]);
    }


    public function logout(Request $request)
{
    Auth::guard('web')->logout();
    Auth::guard('admin')->logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');
}

}