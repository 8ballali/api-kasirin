<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subsrciption extends Model
{
    use HasFactory;
    protected $table = "subscriptions";
    protected  $fillable = ['name','price'];
}
