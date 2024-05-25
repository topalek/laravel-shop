<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Domain\Auth\Models\User;
use DomainException;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirect(string $driver)
    {
        try {
            return Socialite::driver($driver)->redirect();
        } catch (\Throwable $e) {
            throw new DomainException('Произошла ошибка или драйвер не поддерживается');
        }
    }

    public function callback(string $driver)
    {
        if ($driver !== 'github') {
            throw new DomainException('Драйвер не поддерживается');
        }
        $githubUser = Socialite::driver($driver)->user();

        $user = User::query()->updateOrCreate([
            'github_id' => $githubUser->id,
        ], [
            'name'     => $githubUser->name,
            'email'    => $githubUser->email,
            'password' => str()->random(8),
        ]);

        auth()->login($user);

        return to_route('home');
    }
}
