<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ChatRoomModel extends Model
{
    use HasFactory;
    protected $table = 'chat_room';
    protected $primaryKey = 'id';
    public $timestamps = true;

    public function getBlog():BelongsTo
    {
        return $this->belongsTo(BlogModel::class,'blog_id','id');
    }

    public function getCategory():BelongsTo
    {
        return $this->belongsTo(CategoryModel::class,'category_id','id');
    }

    public function senderDetail():BelongsTo
    {
        return $this->belongsTo(User::class,'sender','id');
    }

    public function receiverDetail():BelongsTo
    {
        return $this->belongsTo(User::class,'receiver','id');
    }

    public function getSender(){
        return $this->senderDetail()->select('id', 'name', 'image')->first();
    }

    public function getReceiver(){
        return $this->receiverDetail()->select('id', 'name', 'image')->first();
    }

    public function helpful(): HasMany
    {
        return $this->hasMany(CommentHelpFulModel::class,'chat_room_id', 'id');
    }

    public function isMarkHelpFul($userId = null)
    {
        if (!$userId) {
            $userId = auth()?->user()?->id;
        }
        return $this->helpful()->where('user_id', $userId)->exists();
    }
}
