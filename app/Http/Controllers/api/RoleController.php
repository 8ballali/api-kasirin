<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $response = [
            'success' => true,
            'message' => 'Data Role',
            'data' => $roles
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    public function show($id)
    {
        $roles = Role::find($id);
        if ($roles) {
            return response()->json([
                'success' => true,
                'message' => "Data Role",
                'data'    => $roles
            ],200);
        }else {
            return response()->json([
                'success' => false,
                'message' => "Data Not Found",
                'data' => []
            ],404);
        }
    }

    public function update(Request $request, Role $role)
    {
        $data = $request->all();
        $rules = [
            'name'          => 'required',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $role->update($data);
        $response = [
            'success'   => true,
            'message'   => 'Data Role Updated',
            'data'      => $role,
        ];
        return response()->json($response, Response::HTTP_OK);
    }
}
