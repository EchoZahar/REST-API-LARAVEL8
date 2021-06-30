<?php

/**
 * @OA\Info (
 *     title="Question API swagger documentation",
 *     version="0.0.1",
 *     @OA\Contact(
 *          email="echo.zahar@gmail.com"
 *      ),
 *     @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * )
 * @OA\Server (
 *     url="/api/",
 *     description="Demo tech task API server"
 * )
 * @OA\Tag (
 *     name="Questions",
 *     description="Раздел создания обращения, ответа пользователю, обновление и удаления."
 * )
 * @OA\Tag (
 *     name="Auth Api",
 *     description="API: Регистрация, вход, выход получение и удаление токена."
 * )
 * @OA\SecurityScheme (
 *     type="apiKey",
 *     in="header",
 *     name="X-CSRF-TOKEN",
 *     securityScheme="X-CSRF-TOKEN"
 * )
 */
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

class ApiController extends Controller
{

}
