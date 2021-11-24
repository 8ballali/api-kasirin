<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\Subsrciption;
use Database\Seeders\Subscriptions;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscription = Subsrciption::all();
        return view('admin.table-list-subscription', ['subscription' => $subscription]);
    }
    public function add()
    {
        $subscription = Subsrciption::all();
        return view('admin.table-add-subscription', compact('subscription'));
    }
    public function store(Request $request)
    {
        $data = $request->all();
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'image' => 'required|file|image|mimes:jpeg,png,jpg|max:20480',
            'price' => 'required',
            'duration' => 'required'
        ]);
        $image = null;
        if ($request->image instanceof UploadedFile) {
            $image = $request->image->store('image', 'public');
            $data['image'] = $image;
        }else{
            unset($data['image']);
        }
        Subsrciption::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $image,
            'price' => $request->price,
            'duration' => $request->duration,
        ]);
        return redirect('/kasirin-toko/subscriptions');
    }
    public function edit($id)
    {

        $subscription = Subsrciption::find($id);
        return view('admin.table-edit-subscription', compact('subscription'));
    }
    public function update($id,Request $request)
    {
        $data = $request->all();
        $rules = [
            'name'          => 'required',
            'description'   => 'required',
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
        return redirect('/kasirin-toko/subscriptions');
    }
    public function delete($id){
        $subscriptions = Subsrciption::find($id);
        $subscriptions->delete();
        return redirect ('/kasirin-toko/subscriptions');
    }
}
