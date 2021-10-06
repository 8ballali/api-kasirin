<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Privacy_Policy extends Model
{
    protected $table = "privacy_policy";
    protected $fillable = ['content'];
    use HasFactory;
}
