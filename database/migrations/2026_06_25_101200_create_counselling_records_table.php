<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('counselling_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_registration_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('enquiry_id')->nullable()->constrained()->nullOnDelete();
            $table->string('temp_id', 20)->nullable()->index();
            $table->enum('status', ['pending', 'called', 'visited', 'enrolled', 'dropped'])->default('pending');
            $table->string('full_name');
            $table->string('mobile', 15);
            $table->string('email')->nullable();
            $table->date('dob')->nullable();
            $table->decimal('test_result', 5, 2)->nullable();
            $table->string('batch_selected', 100)->nullable();
            $table->string('ref_no', 50)->nullable();
            $table->string('current_status', 100)->nullable()->comment('e.g. Student, Working, etc.');
            $table->year('year_of_completion')->nullable();
            $table->string('father_occupation', 100)->nullable();
            $table->string('mother_occupation', 100)->nullable();
            $table->string('first_aim', 200)->nullable();
            $table->string('second_aim', 200)->nullable();
            $table->text('purpose_of_training')->nullable();
            $table->boolean('need_job')->default(false);
            $table->string('job_location_preference', 200)->nullable();
            $table->boolean('has_experience')->default(false);
            $table->text('experience_details')->nullable();
            $table->text('remarks')->nullable();
            $table->foreignId('counselled_by_id')->nullable()->constrained('staff')->nullOnDelete();
            $table->string('counselled_with')->nullable()->comment('Third party name if counsellor brought someone');
            $table->timestamps();

            $table->index('status');
            $table->index('mobile');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('counselling_records');
    }
};
