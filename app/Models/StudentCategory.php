<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentCategory extends Model
{
    use HasFactory;
    protected $table = 'student_categories';
    protected $guarded = ['id','created_at','updated_at'];
}
