<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Subsrciption;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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
        if ($request->image instanceof UploadedFile) {
            $image = $request->image->store('image', 'public');
            $data['image'] = $image;
        }else{
            unset($data['image']);
        }
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
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $rules = [
            'name'          => 'required',
            'description'   => 'required',
            'image'         => 'required',
            'price'         => 'required',
            'duration'      => 'required',
        ];
        $this->validate($request, [
        ]);
        $subscriptions = Subsrciption::find($id);
        if (!$subscriptions) {
            return response()->json([
                'message' => 'Subscription Not Found'
            ]);
        }
        if (request()->hasFile('image')) {
            $image = request()->file('image')->store('image', 'public');
            if (Storage::disk('public')->exists($subscriptions->image)) {
                Storage::disk('public')->delete([$subscriptions->image]);
            }
            $image = request()->file('image')->store('image', 'public');
            $data['image'] = $image;
            $subscriptions->update($data);
        }else{
            unset($data['image']);
        }
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $subscriptions->update($data);
        $response = [
            'success'   => true,
            'message'   => 'Data Subsription Updated',
            'data'      => $subscriptions,
        ];
        return response()->json($response, Response::HTTP_OK);
    }
}
