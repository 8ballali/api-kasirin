<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $address = $request->input('address');
        $gender = $request->input('gender');
        $avatar = $request->input('avatar');
        $phone = $request->input('phone');
        $password = Hash::make($request->input('password'));

        $register = User::create([
            'name' => $name,
            'email' => $email,
            'address' => $address,
            'gender' => $gender,
            'avatar' => $avatar,
            'phone' => $phone,
            'password' => $password
        ]);

        if ($register) {
            return response()->json([
                'success' =>true,
                'message' => 'Registrasi Berhasil',
                'data' => $register
            ], 201);
        } else {
            return response()->json([
                'success' =>false,
                'message' => 'Registrasi Gagal',
                'data' => ''
            ], 400);
        }
    }
}
