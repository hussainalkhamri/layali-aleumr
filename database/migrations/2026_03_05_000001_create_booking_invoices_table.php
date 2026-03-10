<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_invoices', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('dress_id')->nullable()->constrained('dresses')->nullOnDelete();
            $table->foreignUuid('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignUuid('branch_id')->nullable()->constrained('branches')->nullOnDelete();
            $table->string('contract_type');
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->date('reserved_for_date');
            $table->date('output_date');
            $table->date('return_date')->nullable();
            $table->text('dress_adjustments')->nullable();
            $table->text('accessories')->nullable();
            $table->decimal('total_amount', 10, 2);
            $table->decimal('paid_advance', 10, 2)->default(0);
            $table->decimal('remaining_amount', 10, 2);
            $table->unsignedInteger('discount_percent')->default(0);
            $table->string('status')->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_invoices');
    }
};
