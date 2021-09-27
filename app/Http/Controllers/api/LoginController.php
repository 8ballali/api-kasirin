<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $user = User::whereEmail($request->email)->first();
        if ($user) {
            return response()->json($user, Response::HTTP_OK );
        }else{
            return response()->json([
                'message' => "User Tidak Ditemukan"
            ], Response::HTTP_NOT_FOUND);
        }

    }
}
