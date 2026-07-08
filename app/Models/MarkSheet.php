<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarkSheet extends Model
{
    use HasFactory;
    protected $table = 'mark_sheets';
    protected $guarded = ['id','created_at','updated_at'];
}
