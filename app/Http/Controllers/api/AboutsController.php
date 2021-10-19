<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AboutsController extends Controller
{
    public function index()
    {
        $abouts = About::all();
        $response = [
            'success' => true,
            'message' => 'data About us',
            'data' => $abouts
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    public function show($id)
    {
        $abouts = About::find($id);
        if ($abouts) {
            return response()->json([
                'success' => true,
                'message' => 'Detail About Us',
                'data' => $abouts
            ]);
        }else {
            return response()->json([
                'success' => false,
                'message' => 'Data About Us Not Found',
                'data' => []
            ],404);
        }

    }

    public function store(Request $request)
    {
        $data = $request->all();
        $rules = [
            'content'=> 'required',
            'title'   => 'required',
            'type' => 'required',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $abouts = About::create($data);
        $response = [
            'success'      => true,
            'message'    => 'Data About Us Created',
            'data'      => $abouts,
        ];
        return response()->json($response, Response::HTTP_CREATED);
    }

    public function update(Request $request, About $abouts)
    {
        $data = $request->all();
        $rules = [
            'content'          => 'required',
            'title'      => 'required',
            'type'   => 'required',
        ];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $abouts->update($data);
        $response = [
            'success'   => true,
            'message'   => 'Data About Us Updated',
            'data'      => $abouts,
        ];
        return response()->json($response, Response::HTTP_OK);
    }
    public function delete($id)
    {
        $abouts = About::findOrFail($id);

        try {
            $abouts->delete();
            $response = [
                'success' => true,
                'message' => 'Data About Us Deleted'
            ];

            return response()->json($response, Response::HTTP_OK);

        } catch (QueryException $e ) {
            return response()->json([
                'message' => "Failed " . $e->errorInfo
            ]);
        }
    }
}
