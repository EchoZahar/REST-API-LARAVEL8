<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

/**
 * Class AuthController
 * @package App\Http\Controllers\API*
 * @OA\Server(
 *     url="127.0.0.1:8000/api/",
 *     description="Demo tech task API server"
 * )
 */
class AuthController extends Controller
{
    /**
     * @param Request $request
     * validate request data
     * create new user
     * add token new user
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     *
     * @OA\Post(
     *      path="/register",
     *      operationId="RegisterNewUser",
     *      tags={"Auth"},
     *      summary="Register new user",
     *      description="Returns question data",
     *      @OA\Parameter(
     *         description="enter your email",
     *         name="email",
     *         in="query",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="enter your eamil",
     *         name="email",
     *         in="query",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="enter your password",
     *         name="password",
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
     *          description="Successful registration",
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
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $token = $user->createToken('apptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application
     * @return \Illuminate\Contracts\Routing\ResponseFactory
     * @return Response
     * check email
     * check password
     * get token this user
     * @OA\Post(
     *     path="/login",
     *     operationId="LoginUser",
     *     tags={"Auth"},
     *     summary="login user",
     *     description="Returns question data",
     *     @OA\Parameter(
     *         description="enter your eamil",
     *         name="email",
     *         in="query",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="enter your password",
     *         name="password",
     *         in="query",
     *         @OA\Schema(
     *             type="password",
     *         )
     *     ),
     *      @OA\RequestBody(
     *          required=true,
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful registration",
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
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);
        // check email
        $user = User::where('email', $data['email'])->first();
        // check password
        if (!$user || !Hash::check($data['password'], $user->password))
        {
            return response([
                'message' => 'Bad credentials'
            ], 401);
        }
        // get token
        $token = $user->createToken('apptoken')->plainTextToken;
        // response if all check
        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    /**
     * @param Request $request
     * @return string[]
     * выход с удалением token пользователя
     *
     * @OA\Post(
     *     path="/logout",
     *     operationId="Logged",
     *     tags={"Auth"},
     *     summary="logout user",
     *     description="Returns question data",
     *     @OA\RequestBody(
     *          required=true,
     *     ),
     *     @OA\Response(
     *          response=201,
     *          description="Successful registration",
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     )
     * )
     */
    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return ['message' => 'logged out'];
    }
}
