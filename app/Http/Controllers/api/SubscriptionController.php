<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Subsrciption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = Subsrciption::all();
        $response = [
            'success' => true,
            'message' => 'data Paket Subscription',
            'data' => $subscriptions
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $rules = [
            'name'          => 'required',
            'description'   => 'required',
            'image'         => 'required',
            'price'         => 'required',
            'duration'      => 'required',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $subscriptions = Subsrciption::create($data);
        return response()->json([
            'success' => true,
            'message' => 'Data Subscription Created',
            'data' => $subscriptions
        ],200);
    }
}
