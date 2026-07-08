<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmissionEnquiry extends Model
{
    use HasFactory;
    protected $table = 'admission_enquiry';
    protected $guarded = ['id','created_at','updated_at'];
}
