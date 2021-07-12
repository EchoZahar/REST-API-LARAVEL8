<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\FilterRequest;
use App\Http\Requests\QuestionStoreRequest;
use App\Http\Requests\QuestionUpdateRequest;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class QuestionController extends ApiController
{
    /**
     * @OA\Get (
     *     path="/questions",
     *     operationId="QuestionAll",
     *     tags={"Questions"},
     *     summary="Получение всех обращении с использоваение простой пагинаций, по 3 обращения (simplePaginate(3))",
     *     @OA\Parameter (
     *        description="Пагинация по страницам",
     *        name="page",
     *        in="query",
     *        @OA\Schema (
     *            type="integer",
     *        )
     *     ),
     *     @OA\Parameter (
     *         description="фильтр по статусу",
     *         name="status",
     *         in="query",
     *         @OA\Schema (
     *             type="string",
     *          ),
     *     ),
     *     @OA\Parameter (
     *         description="выбрать обращения по дате (формат: 2021-12-21) с: ",
     *         name="dateStart",
     *         in="query",
     *         @OA\Schema (
     *             type="date",
     *          ),
     *     ),
     *     @OA\Parameter (
     *         description="выбрать обращения по дате (формат: 2021-12-21) по:",
     *         name="dateEnd",
     *         in="query",
     *         @OA\Schema (
     *             type="date",
     *          ),
     *     ),
     *     @OA\Response (
     *         response="200",
     *         description="Успешно загружено."
     *     ),
     *     @OA\Response (
     *         response=403,
     *         description="Forbidden"
     *     ),
     *     @OA\Response (
     *         response=404,
     *         description="not found"
     *     ),
     * )
     * Display a listing of the resource.
     * @return Response
     */
    public function index(FilterRequest $request)
    {
        /**
         * возвращает загрузку модели
         * все методы можно посмотреть через: dd(get_class_methods($request));
         */
        $filter = Question::query();

        /**
         * фильтрация по статусу
         */
        if ($request->filled('status') != null) {
            $filter->where('status', '=', $request->status);
        }

        /**
         * фильтрация по дате c ...
         */
        if ($request->filled('dateStart')) {
            $filter->whereDate('created_at', '>=', $request->input('dateStart'));
        }

        /**
         * фильтрация по дате до ...
         */
        if ($request->filled('dateEnd')) {
            $filter->whereDate('created_at', '<=', $request->input('dateEnd'));
        }

        /**
         * заявки в диапозоне от и до выбранной даты.
         */
        if ($request->filled('dateStart') && $request->filled('dateEnd')) {
            $filter->whereDate('created_at', '>=', $request->input('dateStart'))
                ->whereDate('created_at', '<=', $request->input('dateEnd'));
        }

        /**
         * метод simplePaginate(), возвращает количество записей на страницу
         * ->withPath('?' . $request->getQueryString()) - принимает значение фильтров,
         * метод getQueryString() добавляет параметр в пагинацию
         * переход по страницам отфильтрованных данных
         */
        return $filter->latest()->simplePaginate(3)->withPath('?' . $request->getQueryString());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     *
     * @OA\Post (
     *     path="/questions/store",
     *     operationId="store",
     *     tags={"Questions"},
     *     summary="Сохранение новой заявки от пользователя",
     *     @OA\RequestBody (
     *         required=true,
     *         @OA\JsonContent (ref="#/components/schemas/QuestionStoreRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Обращение успешно добавлено.",
     *         @OA\JsonContent (ref="#/components/schemas/QuestionRequest")
     *      ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *     )
     * )
     */
    public function store(QuestionStoreRequest $request)
    {
        $question = Question::create($request->only('name', 'email', 'message'));
        return response([$question, ['message' => 'Обращение добаавлено !']], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     *
     * @OA\Get (
     *     path="/questions/show/{question_id}",
     *     operationId="show",
     *     tags={"Questions"},
     *     summary="Показать запись по id",
     *     @OA\Parameter (
     *         name="question_id",
     *         description="ID обращения",
     *         required=true,
     *         in="path",
     *         @OA\Schema (
     *             type="integer"
     *         )
     *      ),
     *     @OA\Response (
     *         response=200,
     *         description="Данные успешно, загружены."
     *     ),
     *     @OA\Response (
     *         response=404,
     *         description="Что то, пошло не так, записи не нaйдено.",
     *     )
     * )
     */
    public function show(int $question_id)
    {
        $question = Question::with('user')->find($question_id);
        if (!$question) {
            return response(['message' => 'не найдено !'], 404);
        }
        return response($question, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     *
     * @param int $id
     *
     * @return Response
     *
     * @OA\Put (
     *     path="/questions/update/{id}",
     *     operationId="update",
     *     tags={"Questions"},
     *     summary="Обновление записи.",
     *     security={
     *         {"app_id": {}},
     *     },
     *     description="Получение ответа на обращение от администратора.",
     *     @OA\Parameter (
     *         name="id",
     *         description="Введите id обращения.",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody (
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/QuestionUpdateRequest")
     *     ),
     *     @OA\Response (
     *         response=200,
     *         description="Запись успешно обновлена",
     *         @OA\JsonContent(ref="#/components/schemas/Questions")
     *      ),
     *      @OA\Response (
     *         response=400,
     *         description="Bad Request"
     *      ),
     *      @OA\Response (
     *         response=401,
     *         description="не авторизован"
     *      ),
     *      @OA\Response (
     *         response=403,
     *         description="Forbidden"
     *      ),
     *      @OA\Response (
     *         response=404,
     *         description="Что то пошло не так, запись не найдена."
     *      ),
     *      @OA\Response (
     *         response=419,
     *         description="Что то пошло не так!"
     *      ),
     *     @OA\Response (
     *         response=422,
     *         description="Что то пошло не так, проверте правильность введенных данных."
     *      )
     * )
     */
    public function update(QuestionUpdateRequest $request, int $id)
    {
        $question = Question::find($id);
        $question->update($request->only('comment','user_id','dateTime','status'));
        return [$question, ['message' => 'Запись успешно обновлена, email отправлен пользователю !']];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     *
     * @OA\Delete (
     *      path="/questions/delete/{id}",
     *      operationId="destroy",
     *      tags={"Questions"},
     *      summary="Удаление обращения",
     *      security={
     *         {"app_id": {}},
     *      },
     *     description="Мягкое удаление (без удаления из БД), возвращается пустой массив.",
     *     @OA\Parameter (
     *         name="id",
     *         description="Введите id обращения для удаления",
     *         required=true,
     *         in="path",
     *         @OA\Schema (type="integer")
     *     ),
     *     @OA\Response (
     *         response=204,
     *         description="Запись успешно удалена"
     *      ),
     *     @OA\Response (
     *         response=401,
     *         description="Unauthenticated"
     *     ),
     *     @OA\Response (
     *         response=403,
     *         description="Forbidden"
     *     ),
     *     @OA\Response (
     *         response=404,
     *         description="Что то пошло не так, запись не найдена."
     *     )
     * )
     */
    public function destroy(int $id)
    {
        $question = Question::find($id);
        if (!$question) {
            return response(['message' => 'не найдено !'], 404);
        }
        $question->delete();
        return response(null, 204);
    }

    /**
     * @param string $name
     * @return Response
     *
     * @OA\Get (
     *     path="/questions/search/{name}",
     *     operationId="search",
     *     tags={"Questions"},
     *     summary="поиск по имени пользователя составивщего заявку",
     *     @OA\Parameter (
     *         description="поиск по имени пользователя составивщего заявку",
     *         name="name",
     *         in="path",
     *         @OA\Schema (
     *             type="string",
     *          ),
     *     ),
     *     @OA\Response (
     *         response=404,
     *         description="не найдено"
     *     ),
     *     @OA\Response (
     *         response="200",
     *         description="статус 'ОК'"
     *     ),
     * )
     */
    public function search($name)
    {
        return Question::where('name', 'like', '%' . $name . '%')->get();
    }
}
