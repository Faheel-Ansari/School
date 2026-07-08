<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminClasses extends Model
{
    use HasFactory;
    protected $table = 'admin_classes';
    protected $guarded = ['id','created_at','updated_at'];
}
