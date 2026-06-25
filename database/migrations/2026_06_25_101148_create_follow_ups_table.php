<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('follow_ups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enquiry_id')->constrained()->cascadeOnDelete();
            $table->foreignId('staff_id')->constrained('staff')->restrictOnDelete();
            $table->text('notes')->nullable();
            $table->dateTime('follow_up_at');
            $table->enum('status', ['pending', 'done', 'rescheduled'])->default('pending');
            $table->dateTime('next_follow_up_at')->nullable();
            $table->timestamps();

            $table->index(['enquiry_id', 'status']);
            $table->index('follow_up_at');
            $table->index(['staff_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('follow_ups');
    }
};
