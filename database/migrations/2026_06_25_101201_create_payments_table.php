<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enrollment_id')->constrained()->cascadeOnDelete();
            $table->enum('payment_type', ['course_fee', 'security_deposit']);
            $table->unsignedInteger('amount');
            $table->enum('mode', ['upi', 'cash']);
            $table->string('transaction_no', 100)->nullable();
            $table->string('payment_medium', 100)->nullable()->comment('e.g. Google Pay, PhonePe, Paytm');
            $table->foreignId('collected_by_id')->nullable()->constrained('staff')->nullOnDelete();

            // Refund tracking (for security deposit)
            $table->boolean('is_refunded')->default(false);
            $table->date('refund_date')->nullable();
            $table->enum('refund_mode', ['upi', 'cash'])->nullable();
            $table->string('refund_upi_id')->nullable();
            $table->string('refund_account_name', 200)->nullable();
            $table->timestamp('refunded_at')->nullable();
            $table->foreignId('refunded_by_id')->nullable()->constrained('staff')->nullOnDelete();
            $table->text('refund_notes')->nullable();

            $table->timestamps();

            $table->index(['enrollment_id', 'payment_type']);
            $table->index('is_refunded');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
