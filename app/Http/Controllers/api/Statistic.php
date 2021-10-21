<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction_detail;

class Statistic extends Controller
{
    public function index()
    {
        $name = DB::table('transaction_details')->join('products', 'products.id', 'product_id')->groupBy('transaction_details.product_id')->selectRaw('count(*) as Dibeli, products.name')->orderByRaw('Dibeli desc')->get();
        return response()->json([
            'success' => true,
            'message' => 'Produk yang sering dibeli',
            'data' => $name
        ],200);
    }
}
