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
        Schema::create('discounts', function (Blueprint $table) {
           $table->uuid('id')->primary()->unique();
            $table->longText('user_ids')->nullable();
            $table->string('title');
            $table->string('code');
            $table->string('amount')->nullable();
            $table->unsignedInteger('percent')->nullable();
            $table->enum('type', ['amount','percent'])->default('percent');
            $table->dateTime('expiration')->nullable();;
            $table->enum('status', ['disable','enable'])->default('disable');
            $table->enum('access', ['public','private'])->default('private');
            $table->unsignedInteger('limitdiscount')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
