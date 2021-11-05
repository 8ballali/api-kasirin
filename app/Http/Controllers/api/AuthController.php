<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\User_Role;
use App\Models\User_Store;
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
        $register = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'gender' => $request->gender,
            'avatar' => $avatar,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);
        $user_role = User_Role::create([
            'user_id' => $register->id,
            'role_id' => '1'
        ]);
        if ($register) {
            return response()->json([
                'success' =>true,
                'message' => 'Registrasi Berhasil',
                'data' => [$register, $user_role]
            ], 201);
        } else {
            return response()->json([
                'success' =>false,
                'message' => 'Registrasi Gagal',

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
                ],200);
            }
            // Jika Hash Tidak sesuai maka Error
            $user = User::where('email', $request->email)->with('user_store.store')->first();
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
                'message' => "Authentication Failed " . $error
            ]);
        }
    }

    public function logout () {
        $user = request()->user(); //or Auth::user()
        // Revoke current user token
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Logout Berhasil',

        ],200);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required',
        ]);
        $current_user = auth()->user();
        if (Hash::check($request->old_password, $current_user->password)) {
            $current_user->update([
                'password' => Hash::make($request->new_password)
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Password Berhasil Diganti',

            ],200);
        }else {
            return response()->json([
                'success' => false,
                'messgae' => 'Old Password Doesnt match our records'
            ],400);
        }
    }
}
