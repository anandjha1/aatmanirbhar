<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->string('temp_id', 20)->nullable()->index();
            $table->foreignId('batch_id')->constrained()->restrictOnDelete();
            $table->foreignId('course_id')->constrained()->restrictOnDelete();
            $table->foreignId('counselling_record_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('details_filled_by_id')->nullable()->constrained('staff')->nullOnDelete();

            // Personal Info
            $table->string('full_name');
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->date('dob')->nullable();
            $table->string('category', 50)->nullable()->comment('General, OBC, SC, ST, etc.');
            $table->string('religion', 50)->nullable();
            $table->string('aadhaar_no', 12)->nullable()->comment('Encrypted at application layer');
            $table->string('phone', 15);
            $table->string('email')->nullable();

            // Address
            $table->string('house_no')->nullable();
            $table->string('area', 200)->nullable();
            $table->string('district', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('pin_code', 10)->nullable();

            // Education
            $table->unsignedSmallInteger('class10_year')->nullable();
            $table->string('class10_board', 100)->nullable();
            $table->string('class10_percentage', 20)->nullable();
            $table->unsignedSmallInteger('class12_year')->nullable();
            $table->string('class12_board', 100)->nullable();
            $table->string('class12_percentage', 20)->nullable();

            // Work Experience
            $table->string('company_name')->nullable();
            $table->unsignedSmallInteger('months_worked')->nullable();
            $table->string('company_location')->nullable();
            $table->string('company2_name')->nullable();
            $table->unsignedSmallInteger('company2_months')->nullable();
            $table->string('company2_location')->nullable();

            // Health
            $table->boolean('hospitalized_last_5_years')->default(false);
            $table->boolean('has_ailment')->default(false);
            $table->text('ailment_details')->nullable();
            $table->boolean('on_medication')->default(false);
            $table->text('medical_notes')->nullable();

            // Job Placement
            $table->boolean('interested_in_placement')->default(false);
            $table->string('interested_sector', 200)->nullable();

            // Emergency & SIDH
            $table->string('emergency_contact', 15)->nullable();
            $table->string('sidh_profile_link')->nullable();
            $table->string('candidate_id', 50)->nullable();
            $table->string('sidh_mobile', 15)->nullable();
            $table->string('sidh_name')->nullable();
            $table->boolean('sidh_ekyc_done')->default(false);

            $table->enum('status', ['pending', 'active', 'completed', 'dropped'])->default('pending');
            $table->timestamps();

            $table->index(['batch_id', 'status']);
            $table->index('phone');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
