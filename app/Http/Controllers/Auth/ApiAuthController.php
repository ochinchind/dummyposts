<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ApiAuthController extends Controller
{
    /**
     * Вход в аккаунт
     *
     * @param  LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $request->authenticate();

            $token = $request->user()->createToken('auth');

            return response()->json([
                'success' => true,
                'message' => 'Успешный вход в аккаунт!',
                'token' => $token->plainTextToken
            ]);
        } catch (\Exception $e) {
            return response()->json([
            'success' => false,
            'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Выход из аккаунта
     *
     * @param  Request      $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'success' => true,
                'message' => 'Вы вышли из аккаунта!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Регистрация пользователя
     *
     * @param  Request      $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required'],
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->string('password')),
            ]);

            event(new Registered($user));

            Auth::login($user);

            $token = $user->createToken('auth');

            return response()->json([
                'success' => true,
                'message' => 'Успешно зарегистрирован!',
                'token'   => $token->plainTextToken
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
