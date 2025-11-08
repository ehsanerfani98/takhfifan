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
        Schema::create('car_file_item_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_id')->constrained('cars')->onDelete('cascade');
            $table->foreignId('car_file_item_id')->constrained('car_file_items')->onDelete('cascade');
            $table->enum('status', ['سالم', 'نامشخص', 'رنگ شده', 'صافکاری بدون رنگ', 'تعمیر شده','تعویض و مشکل‌دار'])->default('سالم');
            $table->text('status_description')->nullable();
            $table->timestamps();

            $table->unique(['car_id', 'car_file_item_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_file_item_values');
    }
};
