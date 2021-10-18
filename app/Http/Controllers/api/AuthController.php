<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

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

    public function login(Request $request)
    {
        // $email = $request->input('email');
        // $password = $request->input('password');

        // $user = User::where('email', $email)->first();

        // if ($user && Hash::check($password, $user->password)) {
        //     $token = base64_encode(Str::random(40));
        //     $fcm_token = base64_encode(Str::random(40));

        //     $user->update([
        //         'token' => $token,
        //         'fcm_token' => $fcm_token,
        //     ]);
        //     return response()->json([
        //         'success' => true,
        //         'message' => 'Login Success!',
        //         'data'=> $user
        //     ], 201);
        // }else {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'email atau password salah',
        //         'data' => ''
        //     ]);
        // }

        try {
            $request->validate([
                'email' => 'required',
                'password' => 'required'
            ]);
            //Check Credentials
            $credentials = request(['email', 'password']);
            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Wrong Email or Password',
                ],500);
            }

            // Jika Hash Tidak sesuai maka Error
            $user = User::where('email', $request->email)->first();
            $user->tokens()->delete();
            $tokenResult = $user->createToken('token')->plainTextToken;
            return response()->json([
                'success' => true,
                'message' => 'Authenticated',
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'data' => $user
            ]);
        } catch (Exception $e ) {
            return response()->json([
                'message' => "Authentication Failed " . $e->errorInfo
            ]);
        }
    }
}
