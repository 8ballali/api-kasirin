<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Facades\File as FacadesFile;
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
        if (request()->hasFile('avatar') && request('avatar') != '') {
            $imagePath = storage_path('app/public/'.$user->avatar);
            // dd($imagePath);
            if(FacadesFile::exists($imagePath)){
                unlink($imagePath);
            }
            $avatar = request()->file('avatar')->store('image', 'public');
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
        $user = User::findOrFail($id);
        $response = [
            'success' => true,
            'message'=> 'Detail User',
            'data' => $user,
        ];
        return response()->json($response, Response::HTTP_OK);

    }
}
