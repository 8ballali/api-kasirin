<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = "contact_us";
    protected $fillable = ['name', 'image', 'content'];
    protected $appends = [
        'image_url',
    ];

    public function getImageUrlAttribute(){
        return url('storage/'. $this->image);
    }
    use HasFactory;
}
