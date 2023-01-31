<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Posts extends Model
{
    use  HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'author',
        'content',
        'image',
        
    ];


    public function getImageAttribute($value)
{
    if ($value) {

        return asset($value);
        
    } else {
        return asset('posts/no-image.jpg');
    }
}



}
