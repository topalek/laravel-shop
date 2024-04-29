<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Http\Controllers\AuthController;
use App\Http\Requests\RegisterFormRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_store_success(): void
    {
        \Event::fake();
        \Notification::fake();

        $request = RegisterFormRequest::factory()->create(['password_confirmation' => 'password']);

        dd($request);
        $response = $this->post(
            action([AuthController::class, 'store']),
            $request
        );
        $user = User::create($request);
    }
}
