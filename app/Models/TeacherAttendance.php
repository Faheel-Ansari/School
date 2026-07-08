<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherAttendance extends Model
{
    use HasFactory;
    protected $table = 'teacher_attendance';
    protected $guarded = ['id', 'created_at', 'updated_at'];
}
