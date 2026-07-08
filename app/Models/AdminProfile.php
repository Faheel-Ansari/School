<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminProfile extends Model
{
    use HasFactory;
    protected $table = 'admin_profile';
    protected $guarded = ['id', 'created_at', 'updated_at'];
}
