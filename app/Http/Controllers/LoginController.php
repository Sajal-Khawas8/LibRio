<?php

namespace App\Http\Controllers;

use App\Http\Requests\Shared\LoginRequest;
use App\Http\Requests\Shared\ResetPasswordRequest;
use App\Http\Requests\Shared\UpdatePasswordRequest;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function create()
    {
        return view("pages.client.login");
    }

    public function store(LoginRequest $req)
    {
        $credentials = $req->validated();
        $credentials["active"] = 1;

        if (!Auth::attempt($credentials, true)) {
            throw ValidationException::withMessages([
                "email" => "Your Email Address and Password couldn't be verified",
                "password" => "Your Email Address and Password couldn't be verified"
            ]);
        }
        $req->session()->regenerate();
        return redirect()->intended(auth()->user()->hasRole('reader') ? '/' : '/admin')->with("success", "Welcome back, " . auth()->user()->name . "!");
    }

    public function destroy(Request $req)
    {
        Auth::logout();
        $req->session()->invalidate();
        $req->session()->regenerateToken();
        return redirect('/')->with("success", "Logged Out Successfully!");
    }

    public function forgotPasswordForm()
    {
        return view('pages.client.forgot-password');
    }

    public function forgotPassword(ResetPasswordRequest $req)
    {
        $status = Password::sendResetLink($req->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', __($status))
            : back()->with('error', __($status));
    }

    public function resetPasswordForm(string $token)
    {
        return view('pages.client.reset-password', compact('token'));
    }

    public function resetPassword(UpdatePasswordRequest $req)
    {
        $status = Password::reset(
            $req->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill(['password' => $password])
                    ->setRememberToken(Str::random(60));
                $user->save();
                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', __($status))
            : back()->with('error', __($status));
    }
}
