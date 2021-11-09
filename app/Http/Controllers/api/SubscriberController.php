<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use App\Models\Subsrciption;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class SubscriberController extends Controller
{
    public function index(Request $request){
        $subscriber = Subscriber::with('user')->with('subscription')->when(($request->get('subscription_id')), function ($query) use ($request)
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

    public function update(Request $request, subscriber $subscriber)
    {
        $subscriber = Subscriber::find();
        $subscriber_trial = Subsrciption::all();
        $rules = [
            'user_id'          => 'required',
            'subscription_id'  => 'required',
            'status_pembayaran' => 'required',
        ];
        $validator = Validator::make($rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        if ($subscriber->stopped_at > Carbon::now()) {
            $subscriber->update([
                'user_id' => $request->id,
                'subscription_id' => $request->subscription_id,
                'status_pembayaran' => 'On Proccess',
                'start_at' => Carbon::now(),
                'stopped_at' => Carbon::now()->addDays($subscriber_trial->duration),
            ]);
        }elseif ($subscriber->stopped_at < Carbon::now()) {
            $subscriber->update([
                'user_id' => $request->id,
                'subscription_id' => $request->subscription_id,
                'status_pembayaran' => 'Success',
                'start_at' => Carbon::now(),
                'stopped_at' => Carbon::now()->addDays($subscriber->duration),
            ]);
        }
        $response = [
            'success'   => true,
            'message'   => 'Data subscriber Updated',
            'data'      => $subscriber,
        ];
        return response()->json($response, Response::HTTP_OK);
    }
}
