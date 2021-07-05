<?php


namespace App\Models\ExamplesAPI;

/**
 * @OA\Schema (
 *     description="Регистрация пользователей.",
 *     type="object",
 *     title="регистрация нового пользователя."
 * )
 */
class AuthRegister
{
    /**
     * @var string
     *
     * @OA\Property (
     *     title="имя пользователя",
     *     description="Нужно ввести имя пользователя. Обязательное поле, минимальная длина 2, максимальное 50.",
     *     format="string",
     *     example="Customer"
     * )
     */
    public $name;

    /**
     * @var string
     *
     * @OA\Property (
     *     title="email пользователя.",
     *     description="email пользователя. Обязателеное поле, минимальная длина 5, максимальная 100. ",
     *     format="string",
     *     example="customer@example.com"
     * )
     */
    public $email;

    /**
     * @var string
     *
     * @OA\Property (
     *     title="пароль пользователя.",
     *     description="введите пароль",
     *     format="password",
     *     example="password"
     * )
     */
    public $password;

    /**
     * @var string
     *
     * @OA\Property (
     *     title="подтверждение пароля",
     *     description="введите пароль еще раз",
     *     format="password",
     *     example="password"
     * )
     */
    public $password_confirmation;
}
