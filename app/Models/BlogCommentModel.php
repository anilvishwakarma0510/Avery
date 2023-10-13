<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlogCommentModel extends Model
{
    use HasFactory;
    protected $table = "blog_comments";
    protected $primaryKey = 'id';
    public $timestamps = true;

    public function commentUser():BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function getUser(){
        return $this->commentUser()->first(['id','name','image']);
    }
}
