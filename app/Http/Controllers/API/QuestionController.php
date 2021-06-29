<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionStoreRequest;
use App\Http\Requests\QuestionUpdateRequest;
use App\Mail\NewQuestionMail;
use App\Mail\SendQuestionMail;
use App\Models\Question;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        return $this->filter($request);
        return Question::latest()->simplePaginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionStoreRequest $request)
    {
        $data = $request->only('name', 'email', 'message');
        $question = Question::create($data);
        if (!$question) {
            return response(['message' => 'что то пошло не так !'], 422);
        }
        // Отправка email сообщения пользователю
        Mail::to($question->email)->send(new NewQuestionMail($question));
        return response($question, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
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
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
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
