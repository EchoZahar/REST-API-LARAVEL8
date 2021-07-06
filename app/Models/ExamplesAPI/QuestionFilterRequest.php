<?php


namespace App\Models\ExamplesAPI;

/**
 * @OA\Schema (
 *     title="Фильтрация обращении.",
 *     description="фильтрация по имени, по дате, выбоор даты, по статусу.",
 *     type="object"
 * )
 */
class QuestionFilterRequest
{
    /**
     * @var string
     *
     * @OA\Property (
     *     title="Статус",
     *     description="фильтрация по статусу.",
     *     enum={"active", "resolved"},
     *     format="string",
     *     example="active, resolved"
     *   ),
     */
    public $status;

    /**
     * @var string
     *
     * @OA\Property (
     *     title="Фильтр по дате",
     *     description="Фильтрация по дате начиная с:",
     *     format="date",
     *     example="2021-12-02"
     * )
     */

    public $dateStart;

    /**
     * @var string
     *
     * @OA\Property (
     *     title="Фильтр по дате",
     *     description="Фильтрация по дате, ДО введеной даты:",
     *     format="date",
     *     example="2021-12-02"
     * )
     */
    public $dateEnd;
}
