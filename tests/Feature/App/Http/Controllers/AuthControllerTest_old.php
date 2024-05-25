<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Listeners\SendEmailNewUserListener;
use App\Notifications\NewUserNotification;
use Database\Factories\UserFactory;
use Domain\Auth\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AuthControllerTestOld extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_success(): void
    {
        $this->get(action([LoginController::class, 'page']))
             ->assertOk()
             ->assertViewIs('auth.login')
             ->assertSee('Вход в аккаунт')
        ;
    }

    public function test_register_page_success(): void
    {
        $this->get(action([RegisterController::class, 'page']))
             ->assertOk()
             ->assertViewIs('auth.register')
             ->assertSee('Регистрация')
        ;
    }

    public function test_forgot_page_success(): void
    {
        $this->get(action([ForgotPasswordController::class, 'page']))
             ->assertOk()
             ->assertViewIs('auth.forgot-password')
             ->assertSee('Забыли пароль')
        ;
    }

    public function test_login_success(): void
    {
        $pass = '123456789';
        $user = UserFactory::new()->create([
            'password' => $pass
        ]);
        $request = [
            'email'    => $user->email,
            'password' => $pass,
        ];
        $response = $this->post(action([LoginController::class, 'handle'], $request));
        $response->assertValid();
        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('home'));
    }

    public function test_logout_success(): void
    {
        $user = UserFactory::new()->create();
        $this->actingAs($user)->delete(action([LoginController::class, 'logout']));
        $this->assertGuest();
    }

    public function test_it_store_success(): void
    {
        \Event::fake();
        \Notification::fake();

        $request = [
            'name'                  => 'Boris Britva',
            'email'                 => 'test@gmail.com',
            'password'              => 'password',
            'password_confirmation' => 'password',
        ];

        $this->assertDatabaseMissing('users', [
            'email' => $request['email'],
        ]);


        $response = $this->post(
            action([RegisterController::class, 'handle']),
            $request
        );

        $response->assertValid();

        $this->assertDatabaseHas('users', [
            'email' => $request['email'],
        ]);

        Event::assertDispatched(Registered::class);
        Event::assertListening(Registered::class, SendEmailNewUserListener::class);
        $user = User::query()->where('email', $request['email'])->first();

        // т.к. NewUserNotification вызывается через очередь, сымитируем отправку
        $event = new Registered($user);
        $listener = new SendEmailNewUserListener();
        $listener->handle($event);

        Notification::assertSentTo($user, NewUserNotification::class);

        $this->assertAuthenticatedAs($user);

        $response->assertRedirect(route('home'));
    }
}
