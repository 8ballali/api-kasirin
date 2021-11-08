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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class KaryawanController extends Controller
{
    public function index(Request $request)

    {
        $karyawan = User::where('role_id', 2)->whereHas('user_store', function ($query) use ($request)
        {
            $query->where('store_id',$request->store_id);
        })->get();
        if ($karyawan->isNotEmpty()) {
            return response()->json([
                'success' => true,
                'message' => 'Data Karyawan',
                'data' => $karyawan,
            ],200);
        }else {
            return response()->json([
                'success' => false,
                'message' => 'Data Karyawan Tidak ditemukan',
                'data' => [],
            ],404);
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
            'role_id' => 2
        ]);

        $user_store = User_Store::create([
            'user_id' => $register->id,
            'store_id' => $request->store_id
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Karyawan has Been Created',
            'data' => [$register,$user_store]
        ]);
    }
    public function update(Request $request, $id )
    {
        $data = $request->all();
        $rules = [
            'name'          => 'required',
            'address'       => 'required',
            'gender'        => 'required',
            'phone'         => 'required',
        ];
        $this->validate($request, [
        ]);
        $karyawan = User::find($id);
        if (!$karyawan) {
            return response()->json([
                'message' => 'User Not Found'
            ]);
        }
        if (request()->hasFile('avatar')) {
            $avatar = request()->file('avatar')->store('image', 'public');
            if (Storage::disk('public')->exists($karyawan->avatar)) {
                Storage::disk('public')->delete([$karyawan->avatar]);
            }
            $avatar = request()->file('avatar')->store('image', 'public');
            $data['avatar'] = $avatar;
            $karyawan->update($data);
        }else{
            unset($data['avatar']);
        }
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
          return response()->json($validator->errors(), 400);
        }
        $karyawan->update($data);
        $response = [
            'success'   => true,
            'message'   => 'Data Karyawan Updated',
            'data'      => $karyawan,
        ];
        return response()->json($response, Response::HTTP_OK);

    }
    public function destroy($id)
    {
        $karyawan = User::find($id);
        if (!$karyawan) {
            return response()->json([
                'success' => false,
                'message' => 'Karyawan Tidak Ditemukan',
            ],404);
        }
        try {
            $karyawan->delete();
            $response = [
                'success' => true,
                'message' => 'Data Karyawan Deleted'
            ];

            return response()->json($response, Response::HTTP_OK);

        } catch (QueryException $e ) {
            return response()->json([
                'message' => "Failed " . $e->errorInfo
            ]);
        }
    }
}
