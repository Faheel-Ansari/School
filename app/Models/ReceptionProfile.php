<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceptionProfile extends Model
{
    use HasFactory;
    protected $table = 'reception_profile';
    protected $guarded = ['id', 'created_at', 'updated_at'];
}
