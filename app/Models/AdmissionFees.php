<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmissionFees extends Model
{
    use HasFactory;
    protected $table = 'admission_fees';
    protected $guarded = ['id','created_at','updated_at'];
}
