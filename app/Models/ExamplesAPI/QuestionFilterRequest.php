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
     */

    public $dateAsc;
    /**
     * @var string
     */

    public $dateStart;

    /**
     * @var string
     */
    public $dateEnd;


}
