<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Transaction_detail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatistikPendapatan extends Controller
{
    public function daily(Request $request)
    {

        $now = Carbon::parse($request->tanggal);
        if (!$request->store_id) {
            return response()->json([
                'success' => false,
                'message' => 'Please insert your store'
            ],400);
        }
        if (!$request->tanggal) {
            return response()->json([
                'success' => false,
                'message' => 'Please insert your date'
            ],400);
        }
        $income_result = Transaction::when(($request->get('store_id')), function ($query) use ($request)
        {
            $query->where('store_id', $request->store_id);

        })->WhereDay('created_at', $now)
        ->get()->sum('price');

            return response()->json([
                'success' => true,
                'message' => 'Statistics Pendapatan',
                'data' => $income_result
            ],200);
    }
    public function weekly(Request $request)
    {
        $now = Carbon::parse($request->tanggal);
        if (!$request->store_id) {
            return response()->json([
                'success' => false,
                'message' => 'Please insert your store'
            ],400);
        }
        if (!$request->tanggal) {
            return response()->json([
                'success' => false,
                'message' => 'Please insert your date'
            ],400);
        }
        $start = $now->startOfWeek()->format('Y-m-d H:i');
        $end = $now->endOfWeek()->format('Y-m-d H:i');
        $income_result = Transaction::when(($request->get('store_id')), function ($query) use ($request)
        {
            $query->where('store_id', $request->store_id);

        })->whereBetween('created_at', [$start, $end])
        ->get()->sum('price');
            return response()->json([
                'success' => true,
                'message' => 'Statistics Pendapatan',
                'data' => $income_result
            ],200);
    }

    public function monthly(Request $request)
    {
        $now = Carbon::parse($request->tanggal);
        if (!$request->store_id) {
            return response()->json([
                'success' => false,
                'message' => 'Please insert your store'
            ],400);
        }
        if (!$request->tanggal) {
            return response()->json([
                'success' => false,
                'message' => 'Please insert your date'
            ],400);
        }
        $income_result = Transaction::when(($request->get('store_id')), function ($query) use ($request)
        {
            $query->where('store_id', $request->store_id);

        })->whereMonth('created_at', $now)
        ->get()->sum('price');
            return response()->json([
                'success' => true,
                'message' => 'Statistics Perbulan',
                'data' => $income_result
            ],200);
    }

    public function yearly(Request $request)
    {
        $now = Carbon::parse($request->tanggal);
        if (!$request->store_id) {
            return response()->json([
                'success' => false,
                'message' => 'Please insert your store'
            ],400);
        }
        if (!$request->tanggal) {
            return response()->json([
                'success' => false,
                'message' => 'Please insert your date'
            ],400);
        }
        $income_result = Transaction::when(($request->get('store_id')), function ($query) use ($request)
        {
            $query->where('store_id', $request->store_id);

        })->whereYear('created_at', $now)
        ->get()->sum('price');
            return response()->json([
                'success' => true,
                'message' => 'Statistics Pertahun',
                'data' => $income_result
            ],200);
    }

}
