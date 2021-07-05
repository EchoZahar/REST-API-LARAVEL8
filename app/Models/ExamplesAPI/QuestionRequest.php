<?php

namespace App\Models\ExamplesAPI;

/**
 * @OA\Schema (
 *     description="Получение всех записей, обращений, структура таблицы.",
 *     type="object",
 *     title="Обращения пользователей."
 * )
 */
class QuestionRequest
{
    /**
     * @var \App\Models\ExamplesAPI\Questions
     *
     * @OA\Property (
     *     title="Данные по обращениям.",
     *     description="Получение всех обращении"
     * )
     */
    public $data;
}

