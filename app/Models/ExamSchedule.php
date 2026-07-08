<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamSchedule extends Model
{
    use HasFactory;
    protected $table = 'exam_schedule';
    protected $guarded = ['id', 'created_at', 'updated_at'];
}
