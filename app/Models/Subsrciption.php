<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subsrciption extends Model
{
    use HasFactory;
    protected $table = "subscriptions";
    protected  $fillable = ['name','description', 'image', 'price', 'duration'];


    protected $appends = [
        'image_url',
    ];

    public function getImageUrlAttribute(){
        return url('storage/'. $this->image);
    }

    public function subscriber()
    {
        return $this->HasOne(Subscriber::class,'');
    }
}


