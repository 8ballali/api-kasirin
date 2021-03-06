<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction_detail extends Model
{
    use HasFactory;
    protected $table = "transaction_details";
    protected $fillable = ['product_id', 'qty', 'transaction_id',];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function transactions()
    {
        return $this->belongsTo(Transaction::class,'transaction_id');
    }

}
