<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyFees extends Model
{
    use HasFactory;
    protected $table = 'monthly_fees';
    protected $guarded = ['id','created_at','updated_at'];
}
