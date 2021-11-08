<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use HasFactory;
    protected $table = "subscribers";
    protected $fillable = ['user_id', 'subscription_id', 'status_pembayaran', 'start_at', 'stopped_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subsrciption::class);
    }


}
