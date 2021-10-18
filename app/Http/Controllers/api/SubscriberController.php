<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class SubscriberController extends Controller
{
    public function index(Request $request){
        $subscriber = Subscriber::with('user')->with('admin')->with('subscription')->when(($request->get('subscription_id')), function ($query) use ($request)
        {
            $query->where('subscription_id', $request->header('subscription_id'));
        })
        ->get();
        $response = [
            'success' => true,
            'message' => 'Data Subscriber',
            'data' => $subscriber
        ];
        return response()->json($response, Response::HTTP_OK);
    }
    public function show($id)
    {
        $subscriber = subscriber::findOrFail($id);
        $response = [
            'success' => true,
            'message' => 'Detail subscriber',
            'data' => $subscriber
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $rules = [
            'user_id'          => 'required',
            'subscription_id' => 'required',
            'status'         => 'required',
            'admin_id'         => 'required',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $subscriber = Subscriber::create($data);
        $response = [
            'success'      => true,
            'message'    => 'Data subscriber Created',
            'data'      => $subscriber,
        ];
        return response()->json($response, Response::HTTP_CREATED);
    }

    public function update(Request $request, subscriber $subscriber)
    {
        $data = $request->all();
        $rules = [
            'user_id'          => 'required',
            'subscription_id' => 'required',
            'status'         => 'required',
            'admin_id'         => 'required',
        ];


        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $subscriber->update($data);
        $response = [
            'success'   => true,
            'message'   => 'Data subscriber Updated',
            'data'      => $subscriber,
        ];
        return response()->json($response, Response::HTTP_OK);
    }
}
