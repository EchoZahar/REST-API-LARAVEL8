<?php


namespace App\Models\ExamplesAPI;

/**
 * @OA\Schema (
 *     description="Авторизация пользователей.",
 *     type="object",
 *     title="Авторизация."
 * )
 */
class AuthLoginRequest
{
    /**
     * @var string
     *
     * @OA\Property (
     *     title="email пользователя.",
     *     description="email пользователя. Обязателеное поле, минимальная длина 5, максимальная 100. ",
     *     format="string",
     *     example="customer@example.com"
     * )
     *
     */
    public $email;

    /**
     * @var string
     *
     * @OA\Property (
     *     title="Пароль пользователя.",
     *     description="введите пароль.",
     *     format="password",
     *     example="password"
     * )
     */
    public $password;
}
