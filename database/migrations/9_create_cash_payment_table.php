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
        Schema::create('cash_payments', function (Blueprint $table) {
            $table->id('payment_id');
            $table->unsignedBigInteger('user_id');
            $table->string('order_id', 100)->unique();
            $table->string('bundle_type', 50);
            $table->string('email');
            $table->string('phone', 20);
            $table->decimal('amount', 10, 2);
            $table->string('payment_proof_path')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('approved_by')->references('user_id')->on('users')->onDelete('set null');

            $table->index('status');
            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cash_payments');
    }
};
