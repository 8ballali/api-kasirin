<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatistikPendapatan extends Controller
{
    public function daily(Request $request)
    {

        $hourInDay = 24;
        $income_result = 0;
        for ($i=1; $i <= $hourInDay; $i++) {
            $day = Transaction::whereTime('created_at', $i)->whereDay('created_at', $request->day)->whereMonth('created_at', $request->month)->whereYear('created_at', $request->year)->where('store_id' , $request->store_id)->sum('price');
            $income_result += $day;
        }
            return response()->json([
                'success' => true,
                'message' => 'Statistics Pendapatan',
                'data' => $income_result
            ],200);
    }
    public function weekly(Request $request)
    {
        $startweek = 31;
        $income_result = 0;
        for ($i=1; $i <= $dateInMonth; $i++) {
            $month = Transaction::whereDay('created_at', $i)->whereMonth('created_at', $request->month)->whereYear('created_at', $request->year)->where('store_id' , $request->store_id)->sum('price');
            $income_result += $month;
        }
            return response()->json([
                'success' => true,
                'message' => 'Statistics Pendapatan',
                'data' => $income_result
            ],200);
    }

    public function monthly(Request $request)
    {
        $dateInMonth = 31;
        $income_result = 0;
        for ($i=1; $i <= $dateInMonth; $i++) {
            $month = Transaction::whereDay('created_at', $i)->whereMonth('created_at', $request->month)->whereYear('created_at', $request->year)->where('store_id' , $request->store_id)->sum('price');
            $income_result += $month;
        }
            return response()->json([
                'success' => true,
                'message' => 'Statistics Perbulan',
                'data' => $income_result
            ],200);
    }
    public function yearly(Request $request)
    {
        $monthInYear = 12;
        $income_result = 0;
        for ($i=1; $i <= $monthInYear; $i++) {
            $year = Transaction::whereMonth('created_at', $i)->whereYear('created_at', $request->year)->where('store_id' , $request->store_id)->sum('price');
            $income_result += $year;
        }
            return response()->json([
                'success' => true,
                'message' => 'Statistics Pertahun',
                'data' => $income_result
            ],200);
    }
}
