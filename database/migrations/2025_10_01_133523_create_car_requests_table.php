<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('car_requests', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_id');
            $table->enum('type', ['sell', 'buy', 'carinspection']);
            $table->foreignId('car_id')->nullable()->constrained()->onDelete('set null');
            $table->json('data')->nullable();
            $table->enum('status', ['در حال بررسی', 'تایید شد', 'رد شد', 'انجام شد'])->default('در حال بررسی');
            $table->timestamps();

            // تعریف foreign key برای UUID
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('car_requests');
    }
};
