<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordFormRequest;
use App\Http\Requests\LoginFormRequest;
use App\Http\Requests\RegisterFormRequest;
use App\Http\Requests\ResetPasswordFormRequest;
use Domain\Auth\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Password;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(LoginFormRequest $request)
    {
        if (!auth()->attempt($request->validated())) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('home'));
    }

    public function signUp()
    {
        return view('auth.register');
    }

    public function register(RegisterFormRequest $request)
    {
        $user = User::query()->create([
            'name'     => $request->get('name'),
            'email'    => $request->get('email'),
            'password' => $request->get('password'),
        ]);

        event(new Registered($user));
        auth()->login($user);
        return redirect()->intended(route('home'));
    }

    public function passwordResetRequest()
    {
        return view('auth.forgot-password');
    }

    public function forgotPassword(ForgotPasswordFormRequest $request)
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            flash()->info(__($status));
            return back();
        }
        return back()->withErrors(['email' => __($status)]);
    }

    public function resetPassword($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function passwordUpdate(ResetPasswordFormRequest $request)
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => bcrypt($password)
                ])->setRememberToken(str()->random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            flash()->info(__($status));
            return back();
        }
        return back()->withErrors(['email' => __($status)]);
    }

    public function logout()
    {
        auth()->logout();

        session()->invalidate();

        session()->regenerateToken();

        return redirect('/');
    }

    public function github()
    {
        return Socialite::driver('github')->redirect();
    }

    public function githubCallback()
    {
        $githubUser = Socialite::driver('github')->user();

        $user = User::query()->updateOrCreate([
            'github_id' => $githubUser->id,
        ], [
            'name'     => $githubUser->name,
            'email'    => $githubUser->email,
            'password' => str()->random(8),
        ]);

        auth()->login($user);

        return redirect()->intended(route('home'));
    }
}
