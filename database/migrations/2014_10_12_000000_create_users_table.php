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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('cnic')->nullable();
            $table->string('email')->nullable();
            // $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role',['admin','superadmin','teacher','student'])->default('student');
            $table->enum('status',['0','1'])->default('1');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
