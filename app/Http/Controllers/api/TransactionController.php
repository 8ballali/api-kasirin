<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Transaction_detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $transaction = Transaction::when(($request->get('tanggal')), function ($query) use ($request)
        {
            $query->whereDate('created_at', 'like', '%' . $request->tanggal . '%' ,);
        })
        ->get();
        if ($transaction->isNotEmpty()) {
            return response()->json([
                'success' => true,
                'message' => 'Data Transaction',
                'code' => 200,
                'data' => $transaction
            ]);
        }else {
            return response()->json([
                'success' =>false,
                'message' => 'Transaction Not Found',
                'code' => 404,
                'data' => []
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $rules = [
            'price'          => 'required',
            'pay'            => 'required',
            'discount'       => 'nullable',
            'change'         => 'required',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $transaction = Transaction::create($data);

            foreach ($request->products as $product) {
                Transaction_detail::create([
                    'product_id' => $product['product_id'],
                    'qty' => $product['qty'],
                    'transaction_id' => $transaction->id,
                ]);

            Product::find($product['product_id'])->decrement('stock', $product['qty']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Transaction Success',
            'data' => $transaction
        ]);

        // return ResponseFormatter::success($transaction);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $transaction = Transaction::find($id);
        if ($transaction) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Transaction',
                'data' => $transaction
            ],200);
        }else {
            return response()->json([
                'success' => false,
                'message' => 'Transaction Not Found',
            ],404);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
