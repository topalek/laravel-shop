<?php

namespace Domain\Auth\Actions;

use Domain\Auth\Contracts\RegisterNewUserContract;
use Domain\Auth\DTOs\NewUser;
use Domain\Auth\Models\User;
use Illuminate\Auth\Events\Registered;

final class RegisterNewUserAction implements RegisterNewUserContract
{
    public function __invoke(NewUser $dto)
    {
        $user = User::query()->create([
            'name'     => $dto->name,
            'email'    => $dto->email,
            'password' => $dto->password,
        ]);

        event(new Registered($user));
        auth()->login($user);
    }

}
