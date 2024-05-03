<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Domain\Auth\Models\User;
use Laravel\Socialite\Facades\Socialite;

class GithubController extends Controller
{
    public function redirect(string $driver)
    {
        return Socialite::driver($driver)->redirect();
    }

    public function callback(string $driver)
    {
        $githubUser = Socialite::driver($driver)->user();

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
