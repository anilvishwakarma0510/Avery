<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentHelpFulModel extends Model
{
    use HasFactory;
    protected $table = 'comment_helpful';
    protected $primaryKey = 'id';
    public $timestamps = true;
}
