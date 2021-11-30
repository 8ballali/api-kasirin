<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserDataResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Facades\File as FacadesFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class EditProfileController extends Controller
{

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
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'message' => 'User Not Found'
            ]);
        }
        if (request()->hasFile('avatar')) {
            $avatar = request()->file('avatar')->store('image', 'public');
            if (Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete([$user->avatar]);
            }
            $image = request()->file('avatar')->store('image', 'public');
            $data['avatar'] = $avatar;
            $user->update($data);
        }else{
            unset($data['avatar']);
        }
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
          return response()->json($validator->errors(), 400);
        }
        $user->update($data);
        $response = [
            'success'   => true,
            'message'   => 'Data User Updated',
            'data'      => $user,
        ];
        return response()->json($response, Response::HTTP_OK);

    }

    public function show($id)
    {
        $user = User::with('user_store.store')->findOrFail($id);
        if ($user) {
            return response()->json([
                'success' => true,
                'message' => 'Detail User',
                'data' => new UserDataResource($user)
            ],200);
        }else {
            return response()->json([
                'success' => false,
                'message' => 'User Not Found',
                'data' => []
            ],200);
        }

    }
}
