<?php


namespace App\Http\Controllers\Auth;


use Domain\Auth\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    protected array $request;

    public function test_page_success(): void
    {
        $this->get(action([LoginController::class, 'page']))
             ->assertOk()
             ->assertSee('Вход в аккаунт')
             ->assertViewIs('auth.login')
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
            action([LoginController::class, 'handle']),
            $this->request
        );
    }

    public function test_validation_fail(): void
    {
        $this->request['password'] = '12345678';
        $this->request()
             ->assertInvalid('email')
        ;
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = [
            'email'    => 'testing@cutcode.ru',
            'password' => '1234567890',
        ];

        User::query()->create(array_merge($this->request, ['name' => 'John Doe']));
    }

    private function findUser(): User
    {
        return User::query()
                   ->where('email', $this->request['email'])
                   ->first()
        ;
    }

}
