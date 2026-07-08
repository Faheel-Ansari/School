<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeesGroup extends Model
{
    use HasFactory;
    protected $table = 'fees_groups';
    protected $guarded = ['id', 'created_at', 'updated_at'];
}
