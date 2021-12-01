<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TrendTransaksiController extends Controller
{
    public function monthly(Request $request)
    {
       $date = Carbon::create($request->year, $request->month);
       $dayOfMonth = $date->daysInMonth;
       if (!$request->store_id) {
        return response()->json([
            'success' => false,
            'message' => 'Please Insert Your Store'
        ],200);
        }

        if (!$request->year) {
            return response()->json([
                'success' => false,
                'message' => 'Please Insert Year'
            ],200);
        }
        $trends = [];
       for ($i=0; $i < $dayOfMonth; $i++) {
            $trends[$i]["total_transaksi"] = Transaction::when(($request->get('store_id')), function ($query) use ($request)
            {
                $query->where('store_id', $request->store_id);
            })->whereDay('created_at', $i)->whereMonth('created_at',  Carbon::parse($date)->setDay($i+2))->whereYear('created_at', $request->year)
            ->get()->sum('price');
            $trends[$i]["waktu"] = Carbon::parse($date)->setDay($i+2);

       }
       return response()->json([
           'data' => $trends
       ],200);
    }
    public function yearly(Request $request)
    {
        $date = Carbon::now()->startOfYear();
        $date = Carbon::create($request->year);
        // dd($date);
        if (!$request->store_id) {
            return response()->json([
                'success' => false,
                'message' => 'Please Insert Your Store'
            ],200);
        }
        // if (!$request->year) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Please Insert Year'
        //     ],200);
        // }
        $month = [];
        for ($m=0; $m < 12 ; $m++) {
            $month[$m]["total_transaksi"]=Transaction::when(($request->get('store_id')), function ($query) use ($request)
            {
                $query->where('store_id', $request->store_id);

            })->whereYear('created_at', Carbon::parse($date)->setMonth($m+2))->get()->sum('price');
            $month[$m]["waktu"] = Carbon::parse($date)->setMonth($m+2);
        }
        return response()->json([
            'data' => $month
        ],200);
    }

    public function weekly(Request $request)
    {
        $now = Carbon::now()->month($request->month)->year($request->year);
        $start = $now->startOfWeek()->format('Y-m-d H:i:s');
        $week = [];
        for ($w=0; $w < 7 ; $w++) {
            $week[$w]["total_ransaksi"] = Transaction::when(($request->get('store_id')), function ($query) use ($request)
            {
                $query->where('store_id', $request->store_id);

            })->whereDate('created_at', Carbon::parse($start)->addDay($w-1))->get()->sum('price');
            $week[$w]["waktu"] = Carbon::parse($start)->addDay($w);
        }
        return response()->json([
            'success' => true,
            'message' => 'Trend Transaksi Weekly',
            'data'    => $week
        ],200);
    }
    public function daily(Request $request)
    {

        $now = Carbon::parse($request->tanggal)->format('Y-m-d');
        $day = [];
        for ($d=0; $d < 24 ; $d++) {
            if ($d < 10) {
                $hours="0".$d;
            }else{
                $hours=$d;
            }
            $time = $now.' '.$hours.":00:00";
            $day[$d]["total_transaksi"] = Transaction::when(($request->get('store_id')), function ($query) use ($request)
            {
                $query->where('store_id', $request->store_id);
            })
            ->whereDate('created_at',\Carbon\Carbon::parse($time))
            ->whereTime('created_at', '>=', \Carbon\Carbon::parse($time))
            ->whereTime('created_at', '<=', \Carbon\Carbon::parse($time)->addHours(1))
            ->get()->sum('price');
            $day[$d]["waktu"] = \Carbon\Carbon::parse($time)."-".\Carbon\Carbon::parse($time)->addHours(1);
        }
        return response()->json([
            'success' => true,
            'message' => 'Trend Daily',
            'data'    => $day
        ],200);
    }
}
