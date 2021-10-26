<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\File as FacadesFile;

class ProductController extends Controller
{
    public function index(Request $request){
        $product = Product::with('category.store')
        ->when(($request->get('category_id')), function ($query) use ($request)
        {
            $query->where('category_id', $request->category_id);
        })
        ->when(($request->get('store_id')), function ($query) use ($request)
        {
            $query->whereHas('category', function ($query) use ($request)
            {
                $query->where('store_id', $request->store_id);
            });
        })
        ->when(($request->get('name')), function ($query) use ($request)
        {
            $query->where('name', 'like', '%' . $request->name . '%');

        })
        ->get();
        if ($product->isNotEmpty()) {
            return response()->json([
                'success' => true,
                'message' => 'Data Product',
                'data' => $product
            ],200);
        }else {
            return response()->json([
                'success' => false,
                'message' => 'Product Not Found',
                'data' => []
            ],404);
        }
    }
    public function show($id)
    {
        $product = Product::find($id);
        if ($product) {
            return response()->json([
                'success' => true,
                'message' => 'detail product',
                'data' => $product
            ],200);
        }else {
            return response()->json([
                'success' => true,
                'message' => 'Product tidak ditemukan',
            ],404);
        }

    }

    public function store(Request $request)
    {
        $data = $request->all();
        $rules = [
            'name'          => 'required',
            'category_id' => 'required',
            'price'         => 'required',
            'stock'         => 'required',
            'barcode'         => 'required',
        ];
        $image = null;
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
        $product = Product::create($data);
        $response = [
            'success'      => true,
            'message'    => 'Data Product Created',
            'data'      => $product,
        ];
        return response()->json($response, Response::HTTP_CREATED);
    }
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $rules = [
            'name'          => 'required',
            'category_id'   => 'required',
            'price'         => 'required',
            'stock'         => 'required',
            'barcode'       => 'required',
        ];
        $this->validate($request, [
        ]);
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'message' => 'Product Not Found'
            ]);
        }
        // $image = null;
        if (request()->hasFile('image') && request('image') != '') {
            // dd($product);
            $imagePath = storage_path('app/public/'.$product->image);
            if(FacadesFile::exists($imagePath)){
                unlink($imagePath);
            }
            $image = request()->file('image')->store('image', 'public');
            $data['image'] = $image;
            $product->update($data);
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
