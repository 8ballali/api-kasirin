<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User_Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class UserRoleController extends Controller
{
    public function index(Request $request)
    {
        $user_role = User_Role::with('user')->with('role')->when(($request->header('role_id')), function ($query) use ($request)
        {
            $query->where('role_id', $request->header('role_id'));
        })
        ->when(($request->header('user_id')), function ($query) use ($request)
        {
            $query->where('user_id', $request->header('user_id'));
        })
        ->get();
        $response = [
            'success' => true,
            'message' => 'Data Role User',
            'data' => $user_role
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $rules = [
            'user_id'          => 'required',
            'role_id'          => 'required',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $user_role = User_Role::create($data);
        $response = [
            'success'      => true,
            'message'    => 'Data User Role Created',
            'data'      => $user_role,
        ];
        return response()->json($response, Response::HTTP_CREATED);
    }
}
