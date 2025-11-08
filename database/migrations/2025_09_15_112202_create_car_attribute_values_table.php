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
        Schema::create('car_attribute_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_id')->constrained()->cascadeOnDelete();
            $table->foreignId('attribute_id')->constrained()->cascadeOnDelete();
            $table->foreignId('attribute_value_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('value_string')->nullable();
            $table->unsignedBigInteger('value_number')->nullable();
            $table->boolean('value_boolean')->nullable();
            $table->string('value_boolean_label')->nullable();
            $table->timestamps();

            $table->unique(['car_id', 'attribute_id']);

            $table->index(['attribute_id', 'attribute_value_id']);
            $table->index('value_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_attribute_values');
    }
};
