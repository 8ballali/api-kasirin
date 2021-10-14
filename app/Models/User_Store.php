<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_Store extends Model
{
    use HasFactory;
    protected $table = "user_stores";
    protected $fillable = ['user_id', 'store_id'];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
