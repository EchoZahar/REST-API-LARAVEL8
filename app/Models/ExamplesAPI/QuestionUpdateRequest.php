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

	/**
	 * @var string
	 *
	 * @OA\Property(
	 *      title="Статус обращения",
	 *      description="По умолчанию статус: active, если администратор ответил на обращение то статус измениться",
	 *      enum={"active", "resolved"},
	 *      format="string",
	 *      example="active, resolved"
	 * )
	 */
    public $status;

	/**
	 * @var string
	 *
	 * @OA\Property(
	 *      title="Дата ответа",
	 *      description="Поля с датой ответа на обращение.",
	 *      format="date",
	 *      example="2021-07-08 00:00:00"
	 * )
	 */
    public $dateTime;
}
