<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\User;
use App\Models\User_Role;
use App\Models\User_Store;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawan = User_Role::all()->with('store');

        if ($karyawan->isNotEmpty()) {
            return response()->json([
                'success' => true,
                'message' => 'data Karyawan',
                'data' => $karyawan
            ],200);
        }else {
            return response()->json([
                'success' => false,
                'message' => 'Karyawan tidak ditemukan',
                'data' => []
            ], 404);
        }
    }

    public function create(Request $request)
    {
        $data = $request->all();
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'gender' => ['required'],
            'password' => ['required'],
            'store_id' => ['required']
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
            'role_id' => 2
        ]);
        $user_store = User_Store::create([
            'user_id' => $register->id,
            'store_id' => $request->store_id
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Karyawan has Been Created',
            'data' => [$register,$user_role,$user_store]
        ]);
    }
}
