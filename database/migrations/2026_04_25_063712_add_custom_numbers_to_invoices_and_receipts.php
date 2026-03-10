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
        Schema::table('booking_invoices', function (Blueprint $table) {
            $table->string('invoice_no')->nullable()->after('id')->index();
        });
        Schema::table('receipts', function (Blueprint $table) {
            $table->string('receipt_no')->nullable()->after('id')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('booking_invoices', function (Blueprint $table) {
            $table->dropColumn('invoice_no');
        });
        Schema::table('receipts', function (Blueprint $table) {
            $table->dropColumn('receipt_no');
        });
    }
};
