<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User_Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class UserStoreController extends Controller
{
    public function index(Request $request)
    {
        $user_stores =$user_stores = User_Store::with('user')->with('store')->when(($request->get('user_id')), function ($query) use ($request)
        {
            $query->where('user_id', $request->get('user_id'));
        })
        ->when(($request->get('store_id')), function ($query) use ($request)
        {
            $query->where('store_id', $request->get('store_id'));
        })
        ->get();
        $response = [
            'success' => true,
            'message' => 'List Toko User',
            'data' => $user_stores
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $rules = [
            'user_id'          => 'required',
            'store_id'          => 'required',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $user_store = User_Store::create($data);
        $response = [
            'success'      => true,
            'message'    => 'Data User Store Created',
            'data'      => $user_store,
        ];
        return response()->json($response, Response::HTTP_CREATED);
    }
    public function update(Request $request, User_Store  $user_stores)
    {
        $data = $request->all();
        $rules = [
            'user_id'    => 'required',
            'store_id'   => 'required',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $user_stores->update($data);
        $response = [
            'success'   => true,
            'message'   => 'Data User Stroes Updated',
            'data'      => $user_stores,
        ];
        return response()->json($response, Response::HTTP_OK);
    }
}
