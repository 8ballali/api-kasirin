<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $fillable = ['name', 'store_id', 'category_id' , 'image', 'price', 'stock', 'barcode'];
    use HasFactory;
}
