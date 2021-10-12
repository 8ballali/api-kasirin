<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class EditProfileController extends Controller
{
    public function update(Request $request, User $user)
    {
        $data = $request->all();
        $rules = [
            'name'          => 'required',
            'avatar'         =>'required',
            'address'       => 'required',
            'gender'        => 'required',
            'phone'         => 'required',
        ];

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
        $user->update($data);
        $response = [
            'success'   => true,
            'message'   => 'Data User Updated',
            'data'      => $user,
        ];
        return response()->json($response, Response::HTTP_OK);
    }
}
