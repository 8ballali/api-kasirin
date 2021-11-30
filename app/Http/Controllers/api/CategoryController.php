<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Categories::with('product')->where('store_id', $request->store_id)
        ->get();
        if ($categories->isNotEmpty()) {
            return response()->json([
                'success' => true,
                'message' => 'Data Category',
                'data' => $categories
            ],200);
        }else {
            return response()->json([
                'success' => false,
                'message' => 'Category Not Found',
                'data' => []
            ],200);
        }
    }

    public function show($id)
    {
        $categories = Categories::find($id);
        if ($categories) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Category',
                'data' => $categories
            ],200);
        }else {
            return response()->json([
                'success' => false,
                'message' => 'Category Not Found',

            ],200);
        }
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $rules = [
            'name'=> 'required',
            'store_id'   => 'required',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $category = Categories::create($data);
        $response = [
            'success'      => true,
            'message'    => 'Data Category Created',
            'data'      => $category,
        ];
        return response()->json($response, Response::HTTP_CREATED);
    }

    public function update(Request $request, Categories $category)
    {
        $data = $request->all();
        $rules = [
            'name'          => 'required',
            'store_id'      => 'required',
        ];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $category->update($data);
        $response = [
            'success'   => true,
            'message'   => 'Data Category Updated',
            'data'      => $category,
        ];
        return response()->json($response, Response::HTTP_OK);
    }
    public function delete($id)
    {
        $category = Categories::findOrFail($id);

        try {
            $category->delete();
            $response = [
                'success' => true,
                'message' => 'Data Category Deleted'
            ,200];

            return response()->json($response, Response::HTTP_OK);

        } catch (QueryException $e ) {
            return response()->json([
                'message' => "Failed " . $e->errorInfo
            ]);
        }
    }
}
