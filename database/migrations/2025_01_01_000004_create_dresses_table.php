<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dresses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('current_branch_id')->nullable()->constrained('branches')->nullOnDelete();
            $table->string('name');
            $table->string('dress_type');
            $table->string('current_status')->default('available');
            $table->string('chest_size')->nullable();
            $table->string('waist_size')->nullable();
            $table->string('color')->nullable();
            $table->unsignedInteger('max_usage_limit')->default(50);
            $table->unsignedInteger('current_usage_count')->default(0);
            $table->decimal('rental_price', 10, 2)->nullable();
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->string('image_url')->nullable();
            $table->boolean('show_in_catalog')->default(false);
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('cleaning_days')->default(2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dresses');
    }
};
