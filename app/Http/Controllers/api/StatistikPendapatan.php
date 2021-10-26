<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatistikPendapatan extends Controller
{
    public function index(Request $request)
    {
        $income = Transaction::all();
        $income = Transaction::with('stores')
        ->when(($request->get('store_id')), function ($query) use ($request)
        {
            $query->where('transactions.store_id' , $request->store_id);
        })
        ->when(($request->get('tanggal')), function ($query) use ($request)
        {
            $query->whereDate('transactions.created_at', 'like', '%' . $request->tanggal . '%' ,);
        })->sum('transactions.price');
        if ($income->isNotEmpty()) {
            return response()->json([
                'success' => true,
                'message' => 'Statistics Pendapatan',
                'data' => $income
            ],200);
        }else {
            return response()->json([
                'success' => false,
                'message' => 'Statistic Not Found',
                'data' => []
            ],200);
        }

    }
}
