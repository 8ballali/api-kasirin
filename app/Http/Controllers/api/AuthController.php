<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->all();
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'gender' => ['required'],
            'password' => ['required'],
        ];
        $avatar = null;
        if ($request->avatar instanceof UploadedFile) {
            $avatar = $request->avatar->store('image', 'public');
            $data['avatar'] = $avatar;
        }else{
            unset($data['avatar']);
        }
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        // dd($data);
        $register = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'gender' => $request->gender,
            'avatar' => $avatar,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
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
            $tokenResult = $user->createToken('authToken')->plainTextToken;
            return response()->json([
                'success' => true,
                'message' => 'Authenticated',
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'data' => $user
            ]);
        } catch (Exception $error ) {
            return response()->json([
                'message' => "Authentication Failed " . $error->errorInfo
            ]);
        }
    }
}
