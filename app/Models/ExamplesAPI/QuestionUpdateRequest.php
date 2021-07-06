<?php

namespace App\Models\ExamplesAPI;

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
     *      title="укажите id пользователя",
     *      description="поле integer 1,2,3",
     *      format="integer",
     *      example=1
     * )
     */
    public $user_id;
}
