<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TrendTransaksiController extends Controller
{
    public function daily(Request $request)
    {
        $now = Carbon::parse($request->tanggal);
        $trend_daily = Transaction::when(($request->get('store_id')), function ($query) use ($request)
        {
            $query->where('store_id', $request->store_id);

        })
        ->select('price', 'created_at')
        ->groupBy('created_at')
        ->WhereDay('created_at', $now)
        ->get();
        return response()->json([
            'success' => true,
            'message' => 'Trend Transaksi',
            'data' => $trend_daily
        ],200);
    }
    public function weekly(Request $request)
    {
        $now = Carbon::parse($request->tanggal);
        $start = $now->startOfWeek()->format('Y-m-d H:i');
        $end = $now->endOfWeek()->format('Y-m-d H:i');
        $trend_weekly = Transaction::when(($request->get('store_id')), function ($query) use ($request)
        {
            $query->where('store_id', $request->store_id);

        })
        ->select('price', 'created_at')
        ->groupBy('created_at')
        ->WhereBetween('created_at', [$start,$end])
        ->get();
        return response()->json([
            'success' => true,
            'message' => 'Trend Transaksi',
            'data' => $trend_weekly
        ],200);
    }


}
