<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogLikeModel extends Model
{
    use HasFactory;
    protected $table = "blog_like";
    protected $primaryKey = 'id';
    public $timestamps = true;
}
