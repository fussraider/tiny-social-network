<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\LogoutRequest;
use App\Http\Requests\RegisterRequest;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;
use App\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    /**
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $input = $request->only('email', 'password');
        $token = JWTAuth::attempt($input);

        if (!$token) {
            return response()->json([
                'result' => false,
                'message' => 'Invalid Email or Password',
            ], 401);
        } else {
            return response()->json([
                'result' => true,
                'message' => 'User authorization was successful',
            ])->withHeaders(['Authorization' =>  $token]);
        }
    }


    /**
     * @param LogoutRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function logout(LogoutRequest $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);

        try {
            JWTAuth::invalidate($request->token);

            return response()->json([
                'result' => true,
                'message' => 'User logged out successfully'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'result' => false,
                'message' => 'Sorry, the user cannot be logged out'
            ], 500);
        }
    }

    /**
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json([
            'result' => true,
            'message' => 'User registration was successful',
            'data' => [
                'user' => $user
            ]
        ]);
    }

    public function refresh()
    {
        return response() ->json([
            'result' => true
        ]);
    }
}
