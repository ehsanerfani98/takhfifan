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
        Schema::create('event_types', function (Blueprint $table) {
            $table->id();
            $table->enum('name', ['birthday', 'wedding-anniversary'])
                ->unique()
                ->comment('شناسه داخلی نوع رویداد');
            $table->string('display_name')
                ->comment('نام نمایشی نوع رویداد');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_types');
    }
};
