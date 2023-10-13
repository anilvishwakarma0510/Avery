<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactAddressModel extends Model
{
    use HasFactory;
    protected $table = "contact_address";
    protected $primaryKey = "id";
    public $timestamps = true;
}
