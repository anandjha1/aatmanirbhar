<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('test_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_registration_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('temp_id', 20)->index();
            $table->decimal('score', 5, 2)->nullable();
            $table->string('batch_selected', 100)->nullable();
            $table->unsignedSmallInteger('time_taken_seconds')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('test_responses');
    }
};
