<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(LoginFormRequest $request)
    {

        if (!Auth::attempt($request->validated())) {
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

    public function register(Request $request)
    {
        return view('auth.register');
    }

    public function forgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function resetPassword()
    {
        return view('auth.reset-password');
    }


}
