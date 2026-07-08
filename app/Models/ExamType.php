<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamType extends Model
{
    use HasFactory;
    protected $table = 'exam_types';
    protected $guarded = ['id', 'created_at', 'updated_at'];
}
