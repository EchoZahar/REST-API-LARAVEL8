<?php

/**
 * @OA\Schema (
 *     description="Обновление записи, заявка от пользователя",
 *     type="object",
 *     title="Ответ пользователю от администратору."
 * )
 */
class QuestionUpdateRequest
{
    /**
     * @var string
     *
     * @OA\Property (
     *     title="Ответ пользователю от администратора.",
     *     description="Введите ответ пользователю, минимальная длина 5,  максимальная 500 символов.",
     *     format="string",
     *     example="какой то, текст."
     * )
     */
    public $comment;

    /**
     * @var int
     *
     * @OA\Property(
     *      title="User ID",
     *      description="Авторизированный пользователь",
     *      format="int64",
     *      example=1
     * )
     */
    public $user_id;
}
