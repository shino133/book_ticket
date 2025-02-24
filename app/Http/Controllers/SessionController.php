<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function store(Request $request)
    {
        // Validate form data
        $credentials = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required'],
        ]);

        // Kiểm tra "Remember Me"
        $remember = $request->boolean('remember-me');

        // Validate credentials
        if (Auth::attempt($credentials, $remember)) {
            // Regenerate session để tránh tấn công Session Fixation
            $request->session()->regenerate();

            return redirect()->intended()
                ->with('status', 'success')
                ->with('message', 'Signed in!');
        }

        // Trả về lỗi nếu đăng nhập thất bại
        return back()
            ->withInput()
            ->withErrors(['email' => 'Your credentials could not be verified.']);
    }

    public function destroy(Request $request)
    {
        Auth::logout();

        // Xóa session của user
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')
            ->with('status', 'success')
            ->with('message', 'Logged Out!');
    }
}
