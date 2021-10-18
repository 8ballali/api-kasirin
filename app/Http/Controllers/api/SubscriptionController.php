<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Subsrciption;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = Subsrciption::all();
        $response = [
            'success' => true,
            'message' => 'data Paket Subscription',
            'data' => $subscriptions
        ];
        return response()->json($response, Response::HTTP_OK);
    }
}
