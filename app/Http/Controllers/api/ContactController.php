<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends Controller
{

    public function index()
    {
        $contact = Contact::all();
        $response = [
            'success' => true,
            'message' => 'Data Contact Us',
            'data' => $contact
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    public function show($id)
    {
        $contact = Contact::find($id);
        if ($contact) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Contact',
                'data' => $contact
            ],200);
        }else {
            return response()->json([
                'success' => false,
                'message' => 'Data Contact Not Found',
                'data' => []
            ],200);
        }
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $rules = [
            'name'=> 'required',
            'content'   => 'required',
        ];
        $image = $request->image->store('image', 'public');
        $data['image'] = $image;
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $contact = Contact::create($data);
        $response = [
            'success'      => true,
            'message'    => 'Data contact Us Created',
            'data'      => $contact,
        ];
        return response()->json($response, Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $rules = [
            'name'          => 'required',
            'content'          => 'required',
        ];
        $contact = Contact::find($id);
        if (!$contact) {
            return response()->json([
                'message' => 'Contact Not Found'
            ]);
        }
        if (request()->hasFile('image')) {
            $image = request()->file('image')->store('image', 'public');
            if (Storage::disk('public')->exists($contact->image)) {
                Storage::disk('public')->delete([$contact->image]);
            }
            $image = request()->file('image')->store('image', 'public');
            $data['image'] = $image;
            $contact->update($data);
        }else{
            unset($data['image']);
        }
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $contact->update($data);
        $response = [
            'success'   => true,
            'message'   => 'Data Contact Updated',
            'data'      => $contact,
        ];
        return response()->json($response, Response::HTTP_OK);
    }
    public function delete($id)
    {
        $contact = Contact::findOrFail($id);

        try {
            $contact->delete();
            $response = [
                'success' => true,
                'message' => 'Data contact Us Deleted'
            ];

            return response()->json($response, Response::HTTP_OK);

        } catch (QueryException $e ) {
            return response()->json([
                'message' => "Failed " . $e->errorInfo
            ]);
        }
    }
}
