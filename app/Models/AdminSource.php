<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminSource extends Model
{
    use HasFactory;
    protected $table = 'source';
    protected $guarded = ['id','created_at','updated_at'];
}
