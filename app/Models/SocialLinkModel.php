<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialLinkModel extends Model
{
    use HasFactory;
    protected $table = 'social_link';
    protected $primaryKey = 'id';
    public $timestamps = true;
}
