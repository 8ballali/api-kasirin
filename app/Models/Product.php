<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
    ];
    protected $fillable = ['name', 'store_id', 'category_id' , 'image', 'price', 'stock', 'barcode'];
    use HasFactory;

    public function category(){
        return $this->belongsTo(Categories::class);
    }
    public function getImageAttribute($value){
        return url('storage/'. $value);
    }
}
