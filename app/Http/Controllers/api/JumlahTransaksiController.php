<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class JumlahTransaksiController extends Controller
{
    public function daily(Request $request)
    {
        $now = Carbon::parse($request->tanggal);
        if (!$request->tanggal) {
            return response()->json([
                'success' => false,
                'message' => 'Please Input Your Date',
            ],400);
        }
        if (!$request->store_id) {
            return response()->json([
                'success' => false,
                'message' => 'Please Input Your Store',
            ],400);
        }
        $jumlah_transaksi = Transaction::when(($request->get('store_id')), function ($query) use ($request)
        {
            $query->where('store_id', $request->store_id);

        })
        ->selectRaw('count(*) as Jumlah_Transaksi')
        ->WhereDay('created_at', $now)
        ->get();
            return response()->json([
                'success' => true,
                'message' => 'Statistics Jumlah Pendapatan',
                'data' => $jumlah_transaksi
            ],200);
    }
    public function weekly(Request $request)
    {
        $now = Carbon::parse($request->tanggal);
        $start = $now->startOfWeek()->format('Y-m-d H:i');
        $end = $now->endOfWeek()->format('Y-m-d H:i');
        if (!$request->tanggal) {
            return response()->json([
                'success' => false,
                'message' => 'Please Input Your Date',
            ],400);
        }
        if (!$request->store_id) {
            return response()->json([
                'success' => false,
                'message' => 'Please Input Your Store',
            ],400);
        }
        $jumlah_transaksi = Transaction::when(($request->get('store_id')), function ($query) use ($request)
        {
            $query->where('store_id', $request->store_id);

        })
        ->selectRaw('count(*) as Jumlah_Transaksi')
        ->WhereBetween('created_at', [$start,$end])
        ->get();
            return response()->json([
                'success' => true,
                'message' => 'Statistics Jumlah Pendapatan',
                'data' => $jumlah_transaksi
            ],200);
    }
    public function monthly(Request $request)
    {
        $now = Carbon::parse($request->tanggal);
        if (!$request->tanggal) {
            return response()->json([
                'success' => false,
                'message' => 'Please Input Your Date',
            ],400);
        }
        if (!$request->store_id) {
            return response()->json([
                'success' => false,
                'message' => 'Please Input Your Store',
            ],400);
        }
        $jumlah_transaksi = Transaction::when(($request->get('store_id')), function ($query) use ($request)
        {
            $query->where('store_id', $request->store_id);

        })
        ->selectRaw('count(*) as Jumlah_Transaksi')
        ->WhereMonth('created_at', $now)
        ->get();
            return response()->json([
                'success' => true,
                'message' => 'Statistics Jumlah Pendapatan',
                'data' => $jumlah_transaksi
            ],200);
    }
    public function yearly(Request $request)
    {
        $now = Carbon::parse($request->tanggal);
        if (!$request->tanggal) {
            return response()->json([
                'success' => false,
                'message' => 'Please Input Your Date',
            ],400);
        }
        if (!$request->store_id) {
            return response()->json([
                'success' => false,
                'message' => 'Please Input Your Store',
            ],400);
        }
        $jumlah_transaksi = Transaction::when(($request->get('store_id')), function ($query) use ($request)
        {
            $query->where('store_id', $request->store_id);

        })
        ->selectRaw('count(*) as Jumlah_Transaksi')
        ->WhereYear('created_at', $now)
        ->get();
            return response()->json([
                'success' => true,
                'message' => 'Statistics Jumlah Pendapatan',
                'data' => $jumlah_transaksi
            ],200);
    }
  }
