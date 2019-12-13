<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request, int $user_id = null){
        if($user_id)
            $user = User::findOrFail($user_id);
        else
            $user = $request->user();

        return response()->json([
            'result' => true,
            'data' => $user
        ]);
    }
}
