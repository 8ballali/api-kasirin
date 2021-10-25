<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
    ];
    protected $fillable = ['name', 'store_id', 'category_id' , 'image', 'price', 'stock', 'barcode', 'store_id'];
    use HasFactory;

    public function category(){
        return $this->belongsTo(Categories::class);
    }

    protected $appends = [
        'image_url',
    ];
    public function getImageUrlAttribute(){
        return url('storage/'. $this->image);
    }

    public function transaction_detail(){
        return $this->hasOne(Transaction_detail::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
