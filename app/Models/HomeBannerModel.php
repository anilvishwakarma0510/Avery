<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeBannerModel extends Model
{
    use HasFactory;
    protected $table = 'home_banner';
    protected $primaryKey = 'id';
    public $timestamps = true;
}
