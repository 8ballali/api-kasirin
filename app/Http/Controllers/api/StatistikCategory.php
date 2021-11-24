<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Transaction_detail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatistikCategory extends Controller
{
    public function daily(Request $request)
    {
        $categories = Transaction_detail::all();
        $now = Carbon::parse($request->tanggal);
        if (!$request->tanggal ) {
            return response()->json([
                'success' => false,
                'message' => 'Please Input date',
            ],400);
        }
        if (!$request->store_id ) {
            return response()->json([
                'success' => false,
                'message' => 'Please Input store',
            ],400);
        }
        $categories_daily = Transaction_detail::join('products', 'products.id', 'product_id')
        ->join('categories', 'categories.id', 'products.category_id')
        ->groupBy('transaction_details.product_id')
        ->selectRaw('count(*) as Dibeli, categories.name')->orderByRaw('Dibeli desc')
        ->when(($request->get('store_id')), function ($query) use ($request)
        {
            $query->where('categories.store_id' , $request->store_id);
        })->whereDay('transaction_details.created_at', $now)
        ->get();
        if ($categories->isNotEmpty()) {
            return response()->json([
                'success' => true,
                'message' => 'Kategori Yang Sering Dibeli',
                'data' => $categories_daily
            ],200);
        }else{
            return response()->json([
                'success' => false,
                'Message' => 'Statistic Not Found',
                'data' => []
            ],200);
        }

    }

    public function weekly(Request $request)
    {
        $categories = Transaction_detail::all();
        $now = Carbon::parse($request->tanggal);
        $start = $now->startOfWeek()->format('Y-m-d H:i');
        $end = $now->endOfWeek()->format('Y-m-d H:i');
        if (!$request->tanggal ) {
            return response()->json([
                'success' => false,
                'message' => 'Please Input date',
            ],400);
        }
        if (!$request->store_id ) {
            return response()->json([
                'success' => false,
                'message' => 'Please Input store',
            ],400);
        }
        $categories_daily = Transaction_detail::whereBetween('transaction_details.created_at', [$start, $end])->join('products', 'products.id', 'product_id')
        ->join('categories', 'categories.id', 'products.category_id')
        ->groupBy('transaction_details.product_id')
        ->selectRaw('count(*) as Dibeli, categories.name')->orderByRaw('Dibeli desc')
        ->when(($request->get('store_id')), function ($query) use ($request)
        {
            $query->where('categories.store_id' , $request->store_id);
        })
        ->get();
        if ($categories->isNotEmpty()) {
            return response()->json([
                'success' => true,
                'message' => 'Kategori Yang Sering Dibeli',
                'data' => $categories_daily
            ],200);
        }else{
            return response()->json([
                'success' => false,
                'Message' => 'Statistic Not Found',
                'data' => []
            ],200);
        }
    }
    public function monthly(Request $request)
    {
        $categories = Transaction_detail::all();
        $now = Carbon::parse($request->tanggal);
        if (!$request->tanggal ) {
            return response()->json([
                'success' => false,
                'message' => 'Please Input date',
            ],400);
        }
        if (!$request->store_id ) {
            return response()->json([
                'success' => false,
                'message' => 'Please Input store',
            ],400);
        }
        $categories_monthly = Transaction_detail::whereMonth('transaction_details.created_at', $now)->join('products', 'products.id', 'product_id')
        ->join('categories', 'categories.id', 'products.category_id')
        ->groupBy('transaction_details.product_id')
        ->selectRaw('count(*) as Dibeli, categories.name')->orderByRaw('Dibeli desc')
        ->when(($request->get('store_id')), function ($query) use ($request)
        {
            $query->where('categories.store_id' , $request->store_id);
        })
        ->get();
        if ($categories->isNotEmpty()) {
            return response()->json([
                'success' => true,
                'message' => 'Kategori Yang Sering Dibeli',
                'data' => $categories_monthly
            ],200);
        }else{
            return response()->json([
                'success' => false,
                'Message' => 'Statistic Not Found',
                'data' => []
            ],200);
        }

    }
    public function yearly(Request $request)
    {
        $categories = Transaction_detail::all();
        $now = Carbon::parse($request->tanggal);
        if (!$request->tanggal ) {
            return response()->json([
                'success' => false,
                'message' => 'Please Input date',
            ],400);
        }
        if (!$request->store_id ) {
            return response()->json([
                'success' => false,
                'message' => 'Please Input store',
            ],400);
        }
        $categories_yearly = Transaction_detail::whereYear('transaction_details.created_at', $now)->join('products', 'products.id', 'product_id')
        ->join('categories', 'categories.id', 'products.category_id')
        ->groupBy('transaction_details.product_id')
        ->selectRaw('count(*) as Dibeli, categories.name')->orderByRaw('Dibeli desc')
        ->when(($request->get('store_id')), function ($query) use ($request)
        {
            $query->where('categories.store_id' , $request->store_id);
        })
        ->get();
        if ($categories->isNotEmpty()) {
            return response()->json([
                'success' => true,
                'message' => 'Kategori Yang Sering Dibeli',
                'data' => $categories_yearly
            ],200);
        }else{
            return response()->json([
                'success' => false,
                'Message' => 'Statistic Not Found',
                'data' => []
            ],200);
        }

    }
}
