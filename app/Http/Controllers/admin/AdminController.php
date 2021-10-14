<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function register(Request $request)
    {
        $email = $request->input('email');
        $password = Hash::make($request->input('password'));

        $register = Admin::create([
            'email' => $email,
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
    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $admin = Admin::where('email', $email)->first();

        if ($admin && Hash::check($password, $admin->password)) {

            return response()->json([
                'success' => true,
                'message' => 'Login Success!',
                'data'=> $admin
            ], 201);
        }else {
            return response()->json([
                'success' => false,
                'message' => 'email atau password salah',
                'data' => ''
            ]);
        }
    }
}
