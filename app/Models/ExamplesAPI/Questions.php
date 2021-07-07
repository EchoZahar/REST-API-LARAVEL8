<?php


namespace App\Models\ExamplesAPI;

/**
 * Class Questions
 * @package App\Models\ExamplesAPI
 *
 * @OA\Schema (
 *     title="Сущность обращения",
 *     description="Модель обращении пользователей, структура и описание.",
 *     @OA\Xml ( name="Question" )
 * )
 */
class Questions
{
    /**
     * @var integer
     *
     * @OA\Property (
     *     title="id",
     *     description="id обрщения",
     *     format="int64",
     *     example=1
     * )
     */
    public $id;

    /**
     * @var string
     * @OA\Property (
     *     title="Имя пользователя",
     *     description="имя обращающегося",
     *     format="string",
     *     example="customer"
     * )
     */
    public $name;

    /**
     * @var
     * @OA\Property (
     *     title="email обращающегося",
     *     description="email пользователя (добавить описане из валидаций)",
     *     format="email",
     *     example="customer@example.com"
     * )
     */
    public $email;

    /**
     * @var
     * @OA\Property (
     *     title="статус записи",
     *     description="2 вида статуса: active (активные обращения) и resolved - закрытый",
     *     format="email",
     *     example="active"
     * )
     */
    public $status;

    /**
     * @var
     * @OA\Property (
     *     title="Обращение от пользователя",
     *     description="",
     *     format="string",
     *     example="Это пример текста обращения."
     * )
     */
    public $message;

    /**
     * @var
     * @OA\Property (
     *     title="Дата ответа от админа",
     *     description="Поле не обязательно для заполнения",
     *     format="datetime",
     *     example="2021-12-21 21:21:21"
     * )
     */
    public $dateAction;

    /**
     * @var
     *
     * @OA\Property (
     *     title="Ответ администратора",
     *     description="Ответ администратора на обращение пользователя",
     *     format="string",
     *     example="Ответ на ваш вопрос ...."
     * )
     */
    public $comment;

    /**
     * @var int
     *
     * @OA\Property (
     *     title="ID польлзователя (админ)",
     *     description="id пользователя ответившего на обращение.",
     *     format="integer",
     *     example="1"
     * )
     */
    public $user_id;

    /**
     * @var
     * @OA\Property (
     *     title="создание обращения",
     *     description="Дата создания обращения пользователя",
     *     format="datetime",
     *     example="2021-12-21 21:21:21"
     * )
     */
    private $created_at;

    /**
     * @var
     * @OA\Property (
     *     title="обновление записи обращения",
     *     description="дата последнего обновления записи.",
     *     format="datetime",
     *     example="2021-12-21 21:21:21"
     * )
     */
    private $updated_at;

    /**
     * @var
     * @OA\Property (
     *     title="удаление обращения",
     *     description="Мягкое удаление, записывается дата удаления обращения",
     *     format="datetime",
     *     example="2021-12-21 21:21:21"
     * )
     */
    private $deleted_at;

    /**
     * @var
     * @OA\Property (
     *     title="администратор",
     *     description="пользователь - администратор, который пищет ответ на обращение.",
     * )
     */
    private $user;
}
