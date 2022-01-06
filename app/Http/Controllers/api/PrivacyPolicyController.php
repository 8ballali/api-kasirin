<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Privacy_Policy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class PrivacyPolicyController extends Controller
{
    public function index()
    {
        $privacy = Privacy_Policy::all();
        $response = [
            'success' => true,
            'message' => 'data Privacy Policy',
            'data' => $privacy
        ];
        return response()->json($response, Response::HTTP_OK);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content' => ['required'],

        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $privacy = Privacy_Policy::create($request->all());
            $response = [
                'success' => true,
                'message' => 'Privacy and Policy has been Created',
                'data' => $privacy
            ];

            return response()->json($response, Response::HTTP_CREATED);

        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed" . $e->errorInfo
            ]);
        }

    }
    public function show($id)
    {
        $privacy = Privacy_Policy::find($id);
        if ($privacy) {
            return response()->json([
                'success' => true,
                'message' => "Data Privacy and Policy",
                'data' => $privacy
            ],200);
        }else {
            return response()->json([
                'success' => false,
                'message' => 'Data Not Found',
                'data'    => $privacy
            ],404);
        }
    }
    public function update(Request $request,$id)
    {
        $privacy = Privacy_Policy::findorFail($id);

        $validator = Validator::make($request->all(), [
            'content' => ['required'],

        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $privacy->update($request->all());
            $response = [
                'success' => true,
                'message' => 'Privacy and Policy has been Updated',
                'data' => $privacy
            ];

            return response()->json($response, Response::HTTP_OK);

        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed" . $e->errorInfo
            ]);
        }
    }
    public function delete($id)
    {
        $privacy = Privacy_Policy::find($id);
        $privacy->delete();
        return response()->json([
            'success' => true,
            'message' => "Successfully deleted"
        ],200);
    }
}
