<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * @return void
     * Авторизация пользователя
     */
    public function testAuthLogin()
    {
        $response = $this->post('api/login', [
            'email' => 'admin@example.com',
            'password' => 'password'
        ]);
        $this->assertEquals(201, $response->status());
    }

    /**
     * Авторизация с неправильным email'ом
     */
    public function testFailedAuthLogin()
    {
        $response = $this->post('/api/login', [
            'email' => 'admin1@example.com',
            'password' => 'password'
        ]);
        $response->assertUnauthorized();
    }

    /**
     * Авторизация с неправильным паролем
     */
    public function testFailedAuthPassword()
    {
        $response = $this->post('/api/login', [
            'email' => 'admin@example.com',
            'password' => 'pasword'
        ]);
        $this->assertEquals(302, $response->status());
    }

    /**
     * Регистрация нового пользователя
     * Пользователь записывается и удаляется из БД,
     * можно закомментировать строку DB::table('users')->where('email', 'admin2@example.com')->delete();
     * для проверки записи.
     */
    public function testNewRegisterUser()
    {
        $response = $this->post('/api/register', [
            'name' => 'admin user #2',
            'email' => 'admin2@example.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);
        $this->assertEquals(201, $response->status());
        DB::table('users')->where('email', 'admin2@example.com')->delete();

    }

    /**
     * Регистрация пользователя с неправльным подтверждением пароля
     */
    public function testFailedRegistrationPassword()
    {
        $response = $this->post('/api/register', [
            'name' => 'admin user #2',
            'email' => 'admin2@example.com',
            'password' => 'password',
            'password_confirmation' => 'passworddd'
        ]);
        $this->assertEquals(302, $response->status());
    }

    /**
     * Попытка зарегестрировать существующего пользователя
     */
    public function testFailedRegistrationIfIssetUser()
    {
        $response = $this->post('/api/register', [
            'name' => 'admin user #2',
            'email' => 'admin@example.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);
        $this->assertEquals(302, $response->status());
    }
}
