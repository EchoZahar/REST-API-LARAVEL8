<?php

namespace App\Observers;

use App\Jobs\SendMailAnswer;
use App\Jobs\SendMailCustomer;
use App\Models\Question;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class QuestionObserver
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the Question "created" event.
     *
     * @param Question $question
     * @return void
     */
    public function created(Question $question)
    {
        dispatch(new SendMailCustomer($question));
        Log::info('Добавлено новое обращение от пользователя: ' . $question->name . '.');
    }

    /**
     * Handle the Question "updated" event.
     *
     * @param Question $question
     * @return void
     */
    public function updated(Question $question)
    {
        $this->setComment($question);
        $this->setUser($question);
        $this->setStatus($question);
        $this->setDateAnswer($question);
        dispatch(new SendMailAnswer($question));
        Log::info('Обновлено обращенее пользователя: ' . $question->name . ', администратором id:' . $question->user_id . '.');
    }

    /**
     * @param Question $question
     * @param $request
     * Если есть комментрарий от администратора, записываю комментарии.
     */
    public function setComment(Question $question)
    {
        if ($this->request->input('comment')) {
            $question->comment = $this->request->input('comment');

        }
    }

    public function setUser(Question $question)
    {
        if ($this->request->input('user_id') == null) {
            $question['user_id'] = auth()->user()->id;
            if (!$question['user_id']) {
                return response(['error' => "Forbidden"]);
            }
        }
    }

    /**
     * @param Question $question
     * Если есть комменатрии от администратора, то статус автоматом меняю на resolved
     */
    public function setStatus(Question $question)
    {
        if ($this->request->input('comment')) {
            $question->status = Question::RESOLVED;
        }
    }

    /**
     * @param Question $question
     * Если есть комменатрии от администратора, то записываю время ответа.
     */
    public function setDateAnswer(Question $question)
    {
        if ($this->request->input('comment')) {
            $question->dateTime = Carbon::now();
        }
    }
}
