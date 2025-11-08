<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('user_subscription_id')->nullable();
            $table->foreign('user_subscription_id')->references('id')->on('user_subscriptions')->onDelete('cascade');
            $table->enum('type', ['wallet_topup', 'subscription_direct', 'subscription_wallet']);
            $table->float('amount');
            $table->float('discount_amount')->nullable();
            $table->float('discount_code')->nullable();
            $table->string('transaction_id')->unique()->nullable();
            $table->string('invoice_number')->nullable()->unique();
            $table->string('authority')->unique()->nullable();
            $table->string('description')->nullable();
            $table->enum('status', ['pending', 'paid', 'failed'])->default('pending');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
