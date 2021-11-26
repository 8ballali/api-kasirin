<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FilterStrukController extends Controller
{
    public function index(Request $request)
    {

        $start = Carbon::parse($request->tanggal_mulai);
        $end = Carbon::parse($request->tanggal_selesai);
        if (!$request->tanggal_mulai) {
            return response()->json([
                'success' => false,
                'message' => 'Please Input Your Date'
            ],400);
        }
        if (!$request->tanggal_selesai) {
            return response()->json([
                'success' => false,
                'message' => 'Please Input Your Date'
            ],400);
        }
        $filter = Transaction::when(($request->get('store_id')), function ($query) use ($request)
        {
            $query->where('store_id', $request->store_id);
        })
        ->WhereBetween('created_at', [$start,$end])
        ->get();
        return response()->json([
            'success' => false,
            'message' => 'Data Transaction',
            'data' => $filter
        ],200);
    }
}
