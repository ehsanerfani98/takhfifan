<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarFileRatingsTable extends Migration
{
    public function up()
    {
        Schema::create('car_file_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_file_id')->constrained()->onDelete('cascade');
            $table->foreignId('car_id')->constrained()->onDelete('cascade');
            $table->enum('rating', ['خوب','متوسط','ضعیف','عالی']);
            $table->timestamps();

            // ایجاد ایندکس برای جلوگیری از رکوردهای تکراری
            $table->unique(['car_file_id', 'car_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('car_file_ratings');
    }
}