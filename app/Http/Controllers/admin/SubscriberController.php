<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use App\Models\Subsrciption;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SubscriberController extends Controller
{
    public function index()
    {
        $subscribers = Subscriber::all();
        $user = User::all();
        $subscription = Subsrciption::all();
        return view('admin.table-list-subscriber', compact('subscribers', 'user', 'subscription'));
    }
    public function edit($id)
    {
        $subscribers = Subscriber::find($id);
        $user = User::all();
        $subscription = Subsrciption::all();
        return view('admin.table-confirmation-subscriber', compact('subscribers', 'user', 'subscription'));
    }
    public function update(Request $request, $id)
    {
        $subscriber = Subscriber::find($id);
        $subscription = Subsrciption::find($request->subscription_id);;
        if ($request->status_pembayaran == 'Failed') {
            $subscriber->update([
                'subscription_id' => $request->subscription_id,
                'status_pembayaran' => $request->status_pembayaran,
                'start_at' => $subscriber->start_at,
                'stopped_at' => $subscriber->stopped_at,
            ]);
        }elseif($subscriber->stopped_at > Carbon::now()) {
            $subscriber->update([
                'subscription_id' => $request->subscription_id,
                'status_pembayaran' => $request->status_pembayaran,
                'start_at' => $subscriber->start_at,
                'stopped_at' => Carbon::now()->addDays($subscription->duration),
            ]);
        }elseif ($subscriber->stopped_at <= Carbon::now()) {
            $subscriber->update([
                'subscription_id' => $request->subscription_id,
                'status_pembayaran' => $request->status_pembayaran,
                'start_at' => Carbon::now(),
                'stopped_at' => Carbon::now()->addDays($subscription->duration),
            ]);
        }
        return redirect('/kasirin-toko/subscribers');
    }
}
