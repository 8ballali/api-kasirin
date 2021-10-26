<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction_detail;

class Statistic extends Controller
{
    public function index(Request $request)
    {
        $product = Transaction_detail::join('products', 'products.id', 'product_id')
        ->join('categories', 'categories.id', 'products.category_id')
        ->groupBy('transaction_details.product_id')
        ->selectRaw('count(*) as Dibeli, products.name')->orderByRaw('Dibeli desc')
        ->when(($request->get('store_id')), function ($query) use ($request)
        {
            $query->where('categories.store_id' , $request->store_id);
        })
        ->when(($request->get('tanggal')), function ($query) use ($request)
        {
            $query->whereDate('transaction_details.created_at', 'like', '%' . $request->tanggal . '%' ,);
        })
        ->get();
        if ($product->isNotEmpty()) {
            return response()->json([
                'success' => true,
                'message' => 'Product yang sering dibeli',
                'data' => $product
            ],200);
        }else {
            return response()->json([
                'success' => false,
                'message' => 'Statistik not Found',
                'data' => []
            ],200);
        }
    }
}
