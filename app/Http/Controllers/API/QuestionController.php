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
     * @OA\Post(
     *      path="/questions",
     *      operationId="QuestionStoreRequest",
     *      operationId="NewQuestionMail",
     *      tags={"Questions"},
     *      summary="Store new question",
     *      description="Returns question data",
     *      @OA\Parameter(
     *         description="enter your name",
     *         name="your name",
     *         in="query",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="enter your eamil",
     *         name="your email",
     *         in="query",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="enter your message",
     *         name="message",
     *         in="query",
     *         @OA\Schema(
     *             type="text",
     *         )
     *     ),
     *      @OA\RequestBody(
     *          required=true,
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function store(QuestionStoreRequest $request)
    {
        $data = $request->only('name', 'email', 'message');
        $question = Question::create($data);
        if (!$question) {
            return response(['message' => 'что то пошло не так !'], 400);
        }
        // Отправка email сообщения пользователю
        Mail::to($question->email)->send(new NewQuestionMail($question));
        return response($question, 201);
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
     *      summary="Show question information",
     *      description="Returns questiion data",
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
     *         description="Question not found",
     *     ),
     *     @OA\Response(
     *          response="default",
     *          response="200",
     *          description="Status OK"
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
     *      operationId="updateQuestion",
     *      tags={"Questions"},
     *      summary="Update existing question",
     *      description="Returns updated project data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Question id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *      ),
     *      @OA\Response(
     *          response=202,
     *          description="Successful updated",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Question Not Found"
     *      )
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
     *      operationId="deleteProject",
     *      tags={"Questions"},
     *      summary="Delete existing question",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="Question id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Successful deleted",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Question Not Found"
     *      )
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
     * @OA\Parameter (
     *         description="Поиск по имени пользователя",
     *         name="search",
     *         in="query",
     *         @OA\Schema(
     *             type="string",
     *          )
     *       ),
     */
    public function search($name)
    {
        return Question::where('name', 'like', '%' . $name . '%')->get();
    }

    /**
     * @param Request $request
     * @return mixed
     * Фильтр метод GET
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
