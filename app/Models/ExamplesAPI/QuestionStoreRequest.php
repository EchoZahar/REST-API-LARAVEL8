<?php

namespace App\Models\ExamplesAPI;

/**
 * @OA\Schema (
 *     description="создание новой записи, заявка от пользователя.",
 *     type="object",
 *     title="Сохранение обращения пользователя."
 * )
 */
class QuestionStoreRequest
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
     *     title="сообщение от пользователя.",
     *     description="сообщение, обращение пользователя, обязателеное поле с максимальным значением 500.",
     *     format="string",
     *     example="Мое сообщение ..........."
     * )
     */
    public $message;
}
