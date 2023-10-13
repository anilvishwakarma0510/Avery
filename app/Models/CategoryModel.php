<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoryModel extends Model
{
    use HasFactory;
    protected $table = 'category';
    protected $primaryKey = 'id';
    public $timestamps = true;

    public function blogs(): HasMany
    {
        return $this->hasMany(BlogModel::class,'category','id');
    }

    public function getBlogCount()
    {
        return $this->blogs()->count();
    }
}
