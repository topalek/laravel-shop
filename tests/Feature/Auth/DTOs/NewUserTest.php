<?php

namespace Auth\DTOs;

use App\Http\Requests\RegisterFormRequest;
use Domain\Auth\DTOs\NewUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_instance_created_from_request()
    {
        $dto = NewUser::fromRequest(new RegisterFormRequest(['name' => 'Joe Doe', 'email' => 'joe@doe.com', 'password' => 'password']));
        $this->assertInstanceOf(NewUser::class, $dto);
        $this->assertEquals($dto->name, 'Joe Doe');
        $this->assertEquals($dto->email, 'joe@doe.com');
        $this->assertEquals($dto->password, 'password');
    }

}
