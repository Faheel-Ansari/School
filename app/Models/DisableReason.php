<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisableReason extends Model
{
    use HasFactory;
    protected $table = 'disable_reasons';
    protected $guarded = ['id', 'created_at', 'updated_at'];
}
