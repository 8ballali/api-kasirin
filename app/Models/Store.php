<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{

    protected $fillable = ['name', 'address', 'user_id',];
    use HasFactory;
    public function user_store()
    {
        return $this->hasMany(User_Store::class,'store_id', 'id');
    }
}
