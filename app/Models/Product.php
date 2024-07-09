<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;

class Product extends Model
{
    use HasFactory;
    protected $guarded=[];

    protected $with=['comment'];

    public function comment(){
        return $this->belongsTo(Comment::class,'product_id','id');
    }
}
