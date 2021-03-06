<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $table = "categories";
    protected $fillable = ['name', 'store_id'];
    use HasFactory;

    public function product(){
        return $this->hasMany(Product::class,'category_id','id');
    }

    public function store(){
        return $this->belongsTo(Store::class,'store_id');
    }
}
