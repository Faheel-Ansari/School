<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentHouse extends Model
{
    use HasFactory;
    protected $table = 'student_houses';
    protected $guarded = ['id', 'created_at', 'updated_at'];
}
