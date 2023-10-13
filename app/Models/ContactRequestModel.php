<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactRequestModel extends Model
{
    use HasFactory;
    protected $table = "contact_request";
    protected $primaryKey = "id";
    public $timestamps = true;
}
