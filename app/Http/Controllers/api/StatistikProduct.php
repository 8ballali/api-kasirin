<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Transaction_detail;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatistikProduct extends Controller
{
    public function daily(Request $request)
    {
        $product = Transaction_detail::all();
        $now = Carbon::parse($request->tanggal);
        if (!$request->tanggal) {
            return response()->json([
                'success' => false,
                'message' => 'Please Input your date'
            ],400);
        }
        if (!$request->store_id) {
            return response()->json([
                'success' => false,
                'message' => 'Please Input your store'
            ],400);
        }
        $product = Transaction_detail::join('products', 'products.id', 'product_id')
        ->join('categories', 'categories.id', 'products.category_id')
        ->groupBy('product_id')
        ->selectRaw('count(*) as Dibeli, products.name')->orderByRaw('Dibeli desc')
        ->when(($request->get('store_id')), function ($query) use ($request)
        {
            $query->where('categories.store_id' , $request->store_id);
        })->whereDay('transaction_details.created_at', $now)
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
    public function weekly(Request $request)
    {
        $now = Carbon::parse($request->tanggal);
        $start = $now->startOfWeek()->format('Y-m-d H:i');
        $end = $now->endOfWeek()->format('Y-m-d H:i');
        if (!$request->tanggal) {
            return response()->json([
                'success' => false,
                'message' => 'Please Input your date'
            ],400);
        }
        if (!$request->store_id) {
            return response()->json([
                'success' => false,
                'message' => 'Please Input your store'
            ],400);
        }
        $product = Transaction_detail::join('products', 'products.id', 'product_id')
        ->join('categories', 'categories.id', 'products.category_id')
        ->groupBy('transaction_details.product_id')
        ->selectRaw('count(*) as Dibeli, products.name')->orderByRaw('Dibeli desc')
        ->when(($request->get('store_id')), function ($query) use ($request)
        {
            $query->where('categories.store_id' , $request->store_id);
        })->whereBetween('transaction_details.created_at', [$start, $end])
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
    public function monthly(Request $request)
    {
        $product = Transaction_detail::all();
        $now = Carbon::parse($request->tanggal);
        if (!$request->tanggal) {
            return response()->json([
                'success' => false,
                'message' => 'Please Input your date'
            ],400);
        }
        if (!$request->store_id) {
            return response()->json([
                'success' => false,
                'message' => 'Please Input your store'
            ],400);
        }
        $product = Transaction_detail::join('products', 'products.id', 'product_id')
        ->join('categories', 'categories.id', 'products.category_id')
        ->groupBy('transaction_details.product_id')
        ->selectRaw('count(*) as Dibeli, products.name')->orderByRaw('Dibeli desc')
        ->when(($request->get('store_id')), function ($query) use ($request)
        {
            $query->where('categories.store_id' , $request->store_id);
        })->whereMonth('transaction_details.created_at', $now)
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
    public function yearly(Request $request)
    {
        $product = Transaction_detail::all();
        $now = Carbon::parse($request->tanggal);
        if (!$request->tanggal) {
            return response()->json([
                'success' => false,
                'message' => 'Please Input your date'
            ],400);
        }
        if (!$request->store_id) {
            return response()->json([
                'success' => false,
                'message' => 'Please Input your store'
            ],400);
        }
        $product = Transaction_detail::join('products', 'products.id', 'product_id')
        ->join('categories', 'categories.id', 'products.category_id')
        ->groupBy('transaction_details.product_id')
        ->selectRaw('count(*) as Dibeli, products.name')->orderByRaw('Dibeli desc')
        ->when(($request->get('store_id')), function ($query) use ($request)
        {
            $query->where('categories.store_id' , $request->store_id);
        })->whereYear('transaction_details.created_at', $now)
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
