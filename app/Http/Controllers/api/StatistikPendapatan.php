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
        $income = DB::table('transactions')->select(DB::raw('*'),DB::raw('sum(price) as income'))
        ->when(($request->get('store_id')), function ($query) use ($request)
        {
            $query->where('transactions.store_id' , $request->store_id);
        })
        ->when(($request->get('tanggal')), function ($query) use ($request)
        {
            $query->whereDate('transactions.created_at', 'like', '%' . $request->tanggal . '%' ,);
        })->get();
        $total_income = $income->sum('income');
            return response()->json([
                'success' => true,
                'message' => 'Statistics Pendapatan',
                'data' => $total_income
            ],200);
    }
}
