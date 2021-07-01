<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\QuestionStoreRequest;
use App\Http\Requests\QuestionUpdateRequest;
use App\Mail\NewQuestionMail;
use App\Mail\SendQuestionMail;
use App\Models\Question;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class QuestionController extends ApiController
{
    /**
     * @OA\Get (
     *     path="/questions",
     *     operationId="QuestionAll",
     *     tags={"Questions"},
     *     summary="Получение всех обращении с использоваение простой пагинаций, по 3 обращения (simplePaginate(3))",
     *     @OA\Parameter (
     *         description="Пагинация по страницам",
     *         name="page",
     *         in="query",
     *         @OA\Schema (
     *             type="integer",
     *         )
     *     ),
     *      @OA\Response (
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response (
     *          response=404,
     *          description="not found"
     *      ),
     *      @OA\Response (
     *          response="200",
     *          description="An example resource"
     *      ),
     * )
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
//        return $this->filter($request);
        return Question::latest()->simplePaginate(2);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     *
     * @OA\Post (
     *     path="/questions",
     *     operationId="storeQuestion",
     *     tags={"Questions"},
     *     summary="Сохранение новой заявки от пользователя",
     *     @OA\RequestBody (
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/QuestionStoreRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Обращение успешно добавлено.",
     *       ),
     *     @OA\Response(
     *          response=201,
     *          description="Обращение успешно добавлено.",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=419,
     *          description="Undocumented, стек срок действия страницы.",
     *       )
     * )
     */
    public function store(QuestionStoreRequest $request)
    {
        $data = $request->only('name', 'email', 'message');
        $question = Question::create($data);
        if (!$question) {
            return response(['message' => 'что то пошло не так !'], 400);
        }
        /**
         * Отправка email сообщения пользователю
         */
        Mail::to($question->email)->send(new NewQuestionMail($question));
        return response($question, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     *
     * @OA\Get (
     *      path="/questions/{id}",
     *      operationId="getQuestionById",
     *      tags={"Questions"},
     *      summary="Показать запись по id",
     *      @OA\Parameter (
     *          name="id",
     *          description="Question ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Response(
     *         response=404,
     *         description="Что то, пошло не так, записи не нсйдено.",
     *     ),
     *     @OA\Response(
     *          response="default",
     *          response="200",
     *          description="Данные успешно, загружены."
     *     )
     * )
     */
    public function show($id)
    {
        $question = Question::find($id);
        if (!$question) {
            return response(['message' => 'не найдено !'], 404);
        }
        return response($question, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     *
     * @OA\Put (
     *     path="/questions/{id}",
     *     operationId="questionUpdate",
     *     tags={"Questions"},
     *     summary="Обновление записи. Добавить ответ от администратора",
     *     security={
     *          {"api_id": {}},
     *     },
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/QuestionUpdateRequest")
     *      ),
     *     @OA\Parameter(
     *          name="id",
     *          description="Метод обновления, по id записи.",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="Обращение успешно добавлено.",
     *       ),
     *      @OA\Response(
     *          response=202,
     *          description="Запись успешно обновлена",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="не авторизован",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Что то пошло не так, запись не найдена."
     *      ),
     *     @OA\Response(
     *          response=419,
     *          description="Undocumented, стек срок действия страницы.",
     *       )
     * )
     */
    public function update(QuestionUpdateRequest $request, $id)
    {
        $question = Question::find($id);
        if (!$question) {
            return response(['message' => 'не найдено !'], 404);
        }
        $data = $request->only('comment');
        if ($data != null) {
            $data['user_id'] = auth()->user()->id;
            $data['status'] = Question::RESOLVED;
            $question->dateTime = Carbon::now();
        }
        $question->update($data);
        Mail::to($question->email)->send(new SendQuestionMail($question));
//        return response($question, 200);
        return [$question, ['message' => 'Запись успешно обновлена, email отправлен пользователю !']];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     *
     * @OA\Delete (
     *     path="/questions/{id}",
     *     operationId="destroy",
     *     tags={"Questions"},
     *     summary="Мягкое удаление (из БД не удаляется) обращения",
     *     security={
     *         {"api_id": {}},
     *     },
     *     @OA\Parameter (
     *         name="id",
     *         description="Question id",
     *         required=true,
     *         in="path",
     *         @OA\Schema (
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response (
     *         response=204,
     *         description="Запись успешно удалена",
     *         @OA\JsonContent()
     *      ),
     *     @OA\Response (
     *         response=401,
     *         description="Unauthenticated",
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
    public function destroy($id)
    {
        $question = Question::find($id);
        if (!$question) {
            return response(['message' => 'не найдено !'], 404);
        }
        $question->destroy($id);
        return response($question, 200);
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
     *          response=404,
     *          description="не найдено"
     *     ),
     *     @OA\Response (
     *          response="200",
     *          description="статус 'ОК'"
     *     ),
     * )
     */
    public function search($name)
    {
        return Question::where('name', 'like', '%' . $name . '%')->get();
    }

    /**
     * @param Request $request
     * @return mixed
     * Фильтр метод GET on index page
     * Если необходимо можно перенести в отдельный репозитории
     * данный метод будет использоваться на главной странице (если будет)
     */
    public function filter(Request $request)
    {
        $status = [
            'активные' => Question::ACTIVE,
            'завершеные' => Question::RESOLVED,
        ];
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
         * фильтрация по возрастанию даты
         */
        if ($request->filled('dateAsc') && $request->input('dateAsc') == 'on') {
            $filter->orderBy('id', 'asc');
        }

        /**
         * фильтрация по убыванию даты
         */
        if ($request->filled('dateDesc') && $request->input('dateDesc') == 'on') {
            $filter->orderBy('id', 'desc');
        }

        if ($request->filled('dateDesc') && $request->filled('dateAsc')) {
            $filter->orderBy('id', 'desc');
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
        $questions = $filter->latest()->simplePaginate(10)->withPath('?' . $request->getQueryString());
        return $questions;
    }
}
