<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorBook extends Model
{
    use HasFactory;
    protected $table = 'visitor_book';
    protected $guarded = ['id','created_at','updated_at'];
}
