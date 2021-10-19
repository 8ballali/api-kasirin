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
        $categories = Categories::with('product')->when(($request->header('store_id')), function ($query) use ($request)
        {
            $query->where('store_id', $request->header('store_id'));
        })->when(($request->get('name')), function ($query) use ($request)
        {
            $query->where('name', 'like', '%' . $request->name . '%');
        })
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
            ],404);
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

            ],404);
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
            ];

            return response()->json($response, Response::HTTP_OK);

        } catch (QueryException $e ) {
            return response()->json([
                'message' => "Failed " . $e->errorInfo
            ]);
        }
    }
}
