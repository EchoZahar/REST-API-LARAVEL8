<?php

use App\Models\Question;

/**
 * @OA\Schema (
 *     description="создание новой записи, заявка от пользователя",
 *     type="object",
 *     title="сохранение обращения пользователя"
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

    /**
     * @var string
     *
     * @OA\Property (
     *     title="Статус записи",
     *     description="По умолчанию статус записи, будет активным.",
     *     format="string",
     *     example="active"
     * )
     */
    public $status = Question::ACTIVE;

    public $dateAction;

    public $comment;

    public $user_id;

    public $user;

    private $created_at;

    private $updated_at;

    private $deleted_at;
}
