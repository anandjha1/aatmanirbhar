<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enquiries', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('mobile', 15);
            $table->string('email')->nullable();
            $table->date('dob')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->string('qualification', 100)->nullable();
            $table->enum('source', [
                'walk_in', 'website', 'on_call', 'whatsapp',
                'instagram', 'facebook', 'student_referral', 'relative_referral', 'other',
            ])->default('walk_in');
            $table->unsignedBigInteger('referral_enrollment_id')->nullable()->comment('FK to enrollments — added after enrollments table');
            $table->string('referral_name')->nullable()->comment('Free-text referral if not a verified student');
            $table->foreignId('interested_course_id')->nullable()->constrained('courses')->nullOnDelete();
            $table->enum('status', [
                'new', 'follow_up', 'test_scheduled', 'test_done', 'counselling_done', 'enrolled', 'dropped',
            ])->default('new');
            $table->foreignId('assigned_to')->nullable()->constrained('staff')->nullOnDelete();
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->index('mobile');
            $table->index('source');
            $table->index('status');
            $table->index('assigned_to');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enquiries');
    }
};
