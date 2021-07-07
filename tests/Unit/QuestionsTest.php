<?php

namespace Tests\Unit;

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
//        dd($response->getContent());
//        $response->assertStatus(200);
        $this->assertEquals(200, $response->status());
    }

    public function testQuestionCreate()
    {
        $response = $this->post('/api/questions/store', [
            'name'      => 'customer',
            'email'     => 'admin@example.com',
            'message'   => 'some questions for customer'
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
            'comment' => 'answer for admin',
            'user_id' => 1
        ]);
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
            'user_id' => ''
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
