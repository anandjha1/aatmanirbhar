<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('test_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enquiry_id')->nullable()->constrained()->nullOnDelete();
            $table->string('temp_id', 20)->unique()->comment('Auto-generated: ACE001, ACE002...');
            $table->string('full_name');
            $table->date('dob')->nullable();
            $table->string('mobile', 15);
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->string('email')->nullable();
            $table->string('qualification', 100)->nullable();
            $table->string('referral')->nullable();
            $table->date('test_date');
            $table->foreignId('course_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();

            $table->index('temp_id');
            $table->index('test_date');
            $table->index('mobile');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('test_registrations');
    }
};
