<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function registerForm()
    {
        return view('auth.register');
    }
    /**
     * @param Request $request
     * validate request data
     * create new user
     * add token new user
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     *
     * @OA\Post(
     *     path="/register",
     *     tags={"Auth Api"},
     *     summary="Регистрация нового пользователя",
     *     description="",
     *     @OA\RequestBody (
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/AuthRegister")
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Пользователь успешно зарегестрирован",
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

    public function loginForm()
    {
        return view('auth.login');
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
     *     tags={"Auth Api"},
     *     summary="Авторизация пользователя",
     *     @OA\RequestBody (
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/AuthLoginRequest")
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
     *     tags={"Auth Api"},
     *     summary="logout user",
     *     description="Returns question data",
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
        Auth::logout();
        return ['message' => 'logged out'];
    }
}
