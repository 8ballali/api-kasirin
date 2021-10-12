<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function index(Request $request){
        $product = Product::when(($request->header('category_id')), function ($query) use ($request)
        {
            $query->where('category_id', $request->header('category_id'));
        })
        ->get();
        $response = [
            'success' => true,
            'message' => "Data Product",
            'data' => $product
        ];
        return response()->json($response, Response::HTTP_OK);
    }
    public function show($id)
    {
        $product = Product::findOrFail($id);
        $response = [
            'success' => true,
            'message' => 'Detail Product',
            'data' => $product
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $rules = [
            'name'          => 'required',
            'category_id' => 'required',
            'image'         => 'required',
            'price'         => 'required',
            'stock'         => 'required',
            'barcode'         => 'required',
        ];


        // if ($request->image instanceof UploadedFile) {
        //     $image = $request->image->store('image', 'public');
        //     $data['image'] = $image;
        // }else{
        //     unset($data['image']);
        // }
        $image = $request->image->store('image', 'public');
        $data['image'] = $image;


        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $product = Product::create($data);
        $response = [
            'success'      => true,
            'message'    => 'Data Product Created',
            'data'      => $product,
        ];
        return response()->json($response, Response::HTTP_CREATED);
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->all();
        $rules = [
            'name'          => 'required',

            'category_id'   => 'required',
            'price'         => 'required',
            'stock'         => 'required',
            'barcode'       => 'required',
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
        $product->update($data);
        $response = [
            'success'   => true,
            'message'   => 'Data Product Updated',
            'data'      => $product,
        ];
        return response()->json($response, Response::HTTP_OK);
    }
    public function delete($id)
    {
        $product = Product::findOrFail($id);

        try {
            $product->delete();
            $response = [
                'success' => true,
                'message' => 'Data Product Deleted'
            ];

            return response()->json($response, Response::HTTP_OK);

        } catch (QueryException $e ) {
            return response()->json([
                'message' => "Failed " . $e->errorInfo
            ]);
        }
    }
}
