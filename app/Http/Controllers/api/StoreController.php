<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\User_Store;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $stores = Store::when(($request->header('user_id')), function ($query) use ($request)
        {
            $query->where('user_id', $request->header('user_id'));
        })->when(($request->get('name')), function ($query) use ($request)
        {
            $query->where('name', 'like', '%'. $request->name . '%');
        })
        ->get();
        if ($stores->isNotEmpty()) {
            return response()-> json([
                'success' => true,
                'message' => 'Data Stores',
                'data' => $stores
            ],200);
        }else {
            return response()->json([
                'success' => false,
                'message' => 'Store Not Found',
                'data' => []
            ],404);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $rules = [
            'name'          => 'required',
            'address'            => 'required',
        ];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $store = Store::create($data);
        $user_store = User_Store::create([
                    'user_id' => $request['user_id'],
                    'store_id' => $store->id,
                ]);
        return response()->json([
            'success' => true,
            'message' => 'store has Been Created',
            'data' => [$store,$user_store]
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $stores = Store::findOrFail($id);
        $response = [
            'success' => true,
            'message'=> 'Detail Toko',
            'data' => $stores,
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $stores = Store::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'address' => ['required'],
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $stores->update($request->all());
            $response = [
                'success' => true,
                'message' => 'Data Stores Updated',
                'data' => $stores
            ];

            return response()->json($response, Response::HTTP_OK);

        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed" . $e->errorInfo
            ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $stores = Store::findOrFail($id);

        try {
            $stores->delete();
            $response = [
                'success'=> true,
                'message' => 'Data Stores Deleted',

            ];

            return response()->json($response, Response::HTTP_OK);

        } catch (QueryException $e ) {
            return response()->json([
                'message' => "Failed " . $e->errorInfo
            ]);
        }
    }
}
