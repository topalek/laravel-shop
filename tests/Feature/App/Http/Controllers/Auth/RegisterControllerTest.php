<?php


namespace App\Http\Controllers\Auth;

use App\Listeners\SendEmailNewUserListener;
use App\Notifications\NewUserNotification;
use Database\Factories\UserFactory;
use Domain\Auth\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    protected array $request;

    public function test_page_success(): void
    {
        $this->get(action([RegisterController::class, 'page']))
             ->assertOk()
             ->assertSee('Регистрация')
             ->assertViewIs('auth.register')
        ;
    }

    public function test_validation_success(): void
    {
        $this->request()
             ->assertValid()
        ;
    }

    private function request(): TestResponse
    {
        return $this->post(
            action([RegisterController::class, 'handle']),
            $this->request
        );
    }

    public function test_should_fail_validation_on_password_confirm(): void
    {
        $this->request['password'] = '123';
        $this->request['password_confirmation'] = '1234';

        $this->request()->assertInvalid(['password']);
    }

    public function test_user_created_success(): void
    {
        $this->assertDatabaseMissing('users', [
            'email' => $this->request['email']
        ]);

        $this->request();

        $this->assertDatabaseHas('users', [
            'email' => $this->request['email']
        ]);
    }

    public function test_should_fail_validation_on_unique_email(): void
    {
        UserFactory::new()->create([
            'email' => $this->request['email']
        ]);

        $this->assertDatabaseHas('users', [
            'email' => $this->request['email']
        ]);

        $this->request()
             ->assertInvalid(['email'])
        ;
    }

    public function test_registered_event_and_listeners_dispatched(): void
    {
        Event::fake();

        $this->request();

        Event::assertDispatched(Registered::class);
        Event::assertListening(
            Registered::class,
            SendEmailNewUserListener::class
        );
    }

    public function test_notification_sent(): void
    {
        $this->request();

        Notification::assertSentTo(
            $this->findUser(),
            NewUserNotification::class
        );
    }

    private function findUser(): User
    {
        return User::query()
                   ->where('email', $this->request['email'])
                   ->first()
        ;
    }

    public function test_user_authenticated_after_and_redirected(): void
    {
        $this->request()
             ->assertRedirect(route('home'))
        ;

        $this->assertAuthenticatedAs($this->findUser());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = [
            'name'                  => 'John Doe',
            'email'                 => 'testing@cutcode.ru',
            'password'              => '1234567890',
            'password_confirmation' => '1234567890'
        ];
    }
}
