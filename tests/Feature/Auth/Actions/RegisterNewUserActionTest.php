<?php

namespace Auth\Actions;

use Domain\Auth\Contracts\RegisterNewUserContract;
use Domain\Auth\DTOs\NewUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterNewUserActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_success_user_created()
    {
        $this->assertDatabaseMissing('users', [
            'email' => 'joe@doe.com',
        ]);

        $action = app(RegisterNewUserContract::class);

        $action(NewUser::make('Joe Doe', 'joe@doe.com', 'password'));

        $this->assertDatabaseHas('users', [
            'email' => 'joe@doe.com',
        ]);
    }

}
