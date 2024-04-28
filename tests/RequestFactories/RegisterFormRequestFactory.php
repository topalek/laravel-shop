<?php

namespace Tests\RequestFactories;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Worksome\RequestFactories\RequestFactory;

class RegisterFormRequestFactory extends RequestFactory
{
    use HasFactory;

    public function definition(): array
    {
        return [
            'email'    => $this->faker->email,
            'name'     => $this->faker->name,
            'password' => $this->faker->password(8),
        ];
    }
}
