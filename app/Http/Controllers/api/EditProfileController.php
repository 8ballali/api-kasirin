<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class EditProfileController extends Controller
{
    public function update(Request $request, User $user)
    {
        $data = $request->all();
        $rules = [
            'name'          => 'required',
            'address'         => 'required',
            'gender'   => 'required',
            'phone'         => 'required',
        ];

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
