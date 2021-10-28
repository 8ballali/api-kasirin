<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\FAQ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class FaqController extends Controller
{
    public function index()
    {
        $faq = FAQ::all();
        $response = [
            'success' => true,
            'message' => 'Data FAQ',
            'data' => $faq
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    public function show($id)
    {
        $faq = FAQ::findOrFail($id);
        if ($faq) {
            return response()->json([
                'success' => true,
                'message' => 'Detail FAQ',
                'data' => $faq
            ],200);
        }else {
            return response()->json([
                'success' => false,
                'message' => 'Data Not Found',
                'data' => []
            ],404);;
        }
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $rules = [
            'questions'=> 'required',
            'answer'   => 'required',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $faq = FAQ::create($data);
        $response = [
            'success'      => true,
            'message'    => 'Data FAQ Created',
            'data'      => $faq,
        ];
        return response()->json($response, Response::HTTP_CREATED);
    }

    public function update(Request $request, FAQ $faq)
    {
        $data = $request->all();
        $rules = [
            'questions'          => 'required',
            'answer'      => 'required',
        ];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $faq->update($data);
        $response = [
            'success'   => true,
            'message'   => 'Data FAQ Updated',
            'data'      => $faq,
        ];
        return response()->json($response, Response::HTTP_OK);
    }
    public function delete($id)
    {
        $faq = FAQ::findOrFail($id);

        try {
            $faq->delete();
            $response = [
                'success' => true,
                'message' => 'Data FAQ Deleted'
            ];

            return response()->json($response, Response::HTTP_OK);

        } catch (QueryException $e ) {
            return response()->json([
                'message' => "Failed " . $e->errorInfo
            ]);
        }
    }
}
