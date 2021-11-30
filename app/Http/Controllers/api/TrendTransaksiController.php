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
       $date = Carbon::now()->day(1)->month($request->month)->year($request->year);
       $dayOfMonth = $date->daysInMonth;
       for ($i=1; $i <= $dayOfMonth; $i++) {
            $trends[] = Transaction::whereDay('created_at', $i)->whereMonth('created_at', $request->month)->whereYear('created_at', $request->year)->sum('price');
       }
       return response()->json([
           'data' => $trends
       ],200);
    }
    public function yearly(Request $request)
    {
        $date = Carbon::parse(now()->month(12)->year($request->year));
        for ($i=1; $i <= $date ; $i++) {
            $trends_year=Transaction::whereMonth('created_at', $i)->whereYear('created_at', $request->year)->sum('price');
        }
        return response()->json([
            'data' => $trends_year
        ],200);
    }


}
