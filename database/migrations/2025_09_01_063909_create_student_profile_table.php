<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('student_profile', function (Blueprint $table) {
            $table->id();
            $table->integer('role_id');
            $table->string('name');
            $table->string('fname')->nullable();
            $table->string('mname')->nullable();
            $table->string('f_phone')->nullable();
            $table->string('f_email')->nullable();
            $table->string('cnic_front')->nullable();
            $table->string('cnic_back')->nullable();
            $table->string('m_phone')->nullable();
            $table->string('m_email')->nullable();
            $table->string('address')->nullable();
            $table->string('board')->nullable();
            $table->string('board_id')->nullable();
            $table->string('grn')->nullable();
            $table->string('class')->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_profile');
    }
};
