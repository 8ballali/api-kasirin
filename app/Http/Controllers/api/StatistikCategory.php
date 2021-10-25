<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Transaction_detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatistikCategory extends Controller
{
    public function index(Request $request)
    {
        $categories = Transaction_detail::all();
        $categories = Transaction_detail::join('products', 'products.id', 'product_id')
        ->join('categories', 'categories.id', 'products.category_id')
        ->groupBy('transaction_details.product_id')
        ->selectRaw('count(*) as Dibeli, categories.name')->orderByRaw('Dibeli desc')
        ->when(($request->get('store_id')), function ($query) use ($request)
        {
            $query->where('categories.store_id' , $request->store_id);
        })
        ->when(($request->get('tanggal')), function ($query) use ($request)
        {
            $query->whereDate('transaction_details.created_at', 'like', '%' . $request->tanggal . '%' ,);
        })
        ->get();
        if ($categories->isNotEmpty()) {
            return response()->json([
                'success' => true,
                'message' => 'Kategori Yang Sering Dibeli',
                'data' => $categories
            ],200);
        }else{
            return response()->json([
                'success' => false,
                'Message' => 'Statistic Not Found',
                'data' => []
            ],404);
        }

    }
}
