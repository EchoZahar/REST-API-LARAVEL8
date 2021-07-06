<?php

namespace App\Models\ExamplesAPI;

/**
 * @OA\Schema (
 *     title="Получение данных.",
 *     description="Получить входящие данные из request метода.",
 *     type="object"
 * )
 */
class QuestionRequest
{
    /**
     * @var Questions
     *
     * @OA\Property (
     *     title="Данные по обращениям.",
     *     description="Получение всех обращении"
     * )
     */
    public $data;
}

