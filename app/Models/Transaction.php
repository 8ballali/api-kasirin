<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    protected $fillable = ['price', 'pay', 'discount', 'change', 'store_id'];
    use HasFactory;

    public function stores()
    {
        return $this->belongsTo(Store::class);
    }
}
