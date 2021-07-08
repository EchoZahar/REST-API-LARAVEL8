<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\TestCase;

class QuestionsTest extends TestCase
{
    /**
     * Получить все обращения
     *
     * @return void
     */
    public function testQuestionsIndex()
    {
        $response = $this->get('/api/questions');
        $this->assertEquals(200, $response->status());
    }

    public function testQuestionCreate()
    {
        $response = $this->post('/api/questions/store', [
            'name'      => 'unit test',
            'email'     => 'admin@example.com',
            'message'   => 'unit test successfully'
        ]);
        $response->assertSuccessful();
    }

    /**
     * Показать обращение
     */
    public function testQuestionsShow()
    {
        $response = $this->get('/api/questions/show/1');
        $response->assertSuccessful();
    }

    /**
     * Успешное обновление, ответ от администратора
     */
    public function testQuestionsUpdate()
    {
        $response = $this->put('/api/questions/update/1', [
            'comment' => 'unit test update.',
            'user_id' => 1,
            'status'  => 'resolved',
            'dateTime'=> Carbon::now()->format('Y-m-d H:i:s')
        ]);
//        dd($response->status(), Carbon::now()->format('Y-m-d H:i:s'));
//        dd($response->status());
        $response->assertSuccessful();
    }

    /**
     * Если нет пользователя то перекинет на главную страницу, код ошибки:302
     * Если нет комментария от администратора то перекинет на главную страницу, код ошибки:302
     */
    public function testQuestionsFailedUpdate()
    {
        $response = $this->put('/api/questions/update/1', [
            'comment' => 'Какой то комментарии от администратора.',
            'user_id' => '',
            'status'  => 'resolved',
            'dateTime'=> Carbon::now()
        ]);
        $response->assertRedirect('/')->assertStatus(302);
    }

    /**
     * Удаление обращения по id
     */
    public function testQuestionDelete()
    {
        $response = $this->delete('/api/questions/delete/1');
        $response->assertStatus(204);

    }
}
