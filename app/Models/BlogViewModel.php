<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogViewModel extends Model
{
    use HasFactory;
    protected $table = 'blog_views';

    protected $primaryKey = 'id';

    public $timestamps = true;

    public $fillable = [
        'blog_id',
        'user_id',
        'ip',
    ];
}
