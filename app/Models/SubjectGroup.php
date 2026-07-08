<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectGroup extends Model
{
    use HasFactory;
    protected $table = 'subject_groups';
    protected $guarded = ['id','created_at','updated_at'];
}
