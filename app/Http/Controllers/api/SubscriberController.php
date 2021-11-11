<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use App\Models\Subsrciption;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $rules = [

            'subscription_id'  => 'required',
        ];
        $subscriber = Subscriber::where('user_id',$id)->first();

        if (request()->hasFile('foto_struk')) {
            $foto_struk = request()->file('foto_struk')->store('image', 'public');
            if (Storage::disk('public')->exists($subscriber->image)) {
                Storage::disk('public')->delete([$subscriber->image]);
            }
            $foto_struk = request()->file('foto_struk')->store('image', 'public');
            $data['foto_struk'] = $foto_struk;
            $subscriber->update($data);
        }else{
            unset($data['image']);
        }
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $subscriber->update([
            'subscription_id' => $request->subscription_id,
            'status_pembayaran' => 'On Proccess',
            'start_at' => $subscriber->start_at,
            'stopped_at' => $subscriber->stopped_at,
        ]);
        $response = [
            'success'   => true,
            'message'   => 'Data subscriber Updated',
            'data'      => $subscriber,
        ];
        return response()->json($response, Response::HTTP_OK);
    }
}
