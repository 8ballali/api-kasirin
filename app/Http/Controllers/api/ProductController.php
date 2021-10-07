<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
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

    public function store(Request $request)
    {
        $data = $request->all();
        $rules = [
            'name'          => 'required',
            'store_id'   => 'required',
            'category_id' => 'required',
            'image'         => 'required',
            'price'         => 'required',
            'stock'         => 'required',
            'barcode'         => 'required',
        ];
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
        dd($data);

        $rules = [
            'name'          => 'required',
            'store_id'      => 'required',
            'category_id'   => 'required',
            'image'         => 'required',
            'price'         => 'required',
            'stock'         => 'required',
            'barcode'       => 'required',
        ];
        // if ($request->image) {
        //     $image = $request->image->store('image', 'public');
        //     $data['image'] = $image;
        // }
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $product->update($data);
        $response = [
            'success'   => true,
            'message'   => 'Data Product Created',
            'data'      => $product,
        ];
        return response()->json($response, Response::HTTP_CREATED);

        // $validator = Validator::make($request->all(), [
        //     'name' => ['required'],
        //     'store_id' => ['required'],
        //     'category_id' => ['required'],
        //     'image' => ['required'],
        //     'price' => ['required', 'numeric'],
        //     'stock' => ['required'],
        //     'barcode' => ['required'],

        // ]);
        // if ($validator->fails()) {
        //     return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        // }
        // if ($request->image) {
        //     $image = $request->image('image');

        //     $nama_image = time() . "_" . $image->getClientOriginalName();

        //     // isi dengan nama folder tempat kemana image diupload
        //     $tujuan_upload = 'storage';
        //     $image->move($tujuan_upload, $nama_image);
        //     @unlink(public_path('/') . '/storage/' . $product->image);
        // }else{
        //     $nama_image=$product->image;
        // }
        // try {
        //     $product->update($request->all());
        //     $response = [
        //         'message' => 'Data Product Updated',
        //         'data' => $product
        //     ];

        //     return response()->json($response, Response::HTTP_OK);

        // } catch (QueryException $e) {
        //     return response()->json([
        //         'message' => "Failed" . $e->errorInfo
        //     ]);
        // }
    }
}
