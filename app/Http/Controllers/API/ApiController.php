<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    /**
     * Этот контроллер создан исключительно для документаций и ни где не будет использоваться в проекте.
     * @OA\Info (
     *     title="Question API swagger documentation",
     *     version="0.0.2",
     *     @OA\Contact(
     *          email="echo.zahar@gmail.com"
     *      ),
     *     @OA\License(
     *          name="Apache 2.0",
     *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *      )
     * )
     * @OA\Server (
     *     url=L5_SWAGGER_CONST_HOST,
     *     description="Demo tech task API server"
     * )
     *
     * @OA\Tag (
     *     name="Auth Api",
     *     description="API: Регистрация, вход, выход получение и удаление токена."
     * )
     * @OA\Tag (
     *     name="Questions",
     *     description="Раздел создания обращения, ответа пользователю, обновление и удаления."
     * )
     * @OA\SecurityScheme (
     *     type="apiKey",
     *     in="header",
     *     name="X-APP-ID",
     *     securityScheme="X-APP-ID"
     * )
     */
}
