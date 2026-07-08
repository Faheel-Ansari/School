<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminComplaint extends Model
{
    use HasFactory;
    protected $table = 'complaint_types';
    protected $guarded = ['id','created_at','updated_at'];
}
