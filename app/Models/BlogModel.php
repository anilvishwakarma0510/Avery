<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BlogModel extends Model
{
    use HasFactory;
    protected $table = "blogs";
    protected $primaryKey = "id";
    public $timestamps = true;

    public function blog_category():BelongsTo
    {
        return $this->belongsTo(CategoryModel::class,'category', 'id');
    }

    public function likes(): HasMany
    {
        return $this->hasMany(BlogLikeModel::class,'blog_id', 'id');
    }

    public function blog_views(): HasMany
    {
        return $this->hasMany(BlogViewModel::class,'blog_id', 'id');
    }
    public function comments(): HasMany
    {
        return $this->hasMany(BlogCommentModel::class,'blog_id', 'id');
    }

    public function isLikeByUser($userId = null)
    {
        if (!$userId) {
            $userId = auth()?->user()?->id;
        }

        $ip = request()->ip();
        return $this->likes()->where('ip', $ip)->exists();
    }

    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }
    public function getCommentsCountAttribute()
    {
        return $this->comments()->count();
    }
    public function getBlogViews()
    {
        return $this->blog_views()->count();
    }
}
