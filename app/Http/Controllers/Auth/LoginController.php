<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginFormRequest;
use Illuminate\Support\Facades\View;
use Illuminate\View\Factory;

class LoginController extends Controller
{
    public function page(): Factory|View
    {
        return view('auth.login');
    }

    public function handle(LoginFormRequest $request)
    {
        if (!auth()->attempt($request->validated())) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('home'));
    }
}
