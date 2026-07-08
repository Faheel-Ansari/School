<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeesType extends Model
{
    use HasFactory;
    protected $table = 'fees_types';
    protected $guarded = ['id', 'created_at', 'updated_at'];
}
