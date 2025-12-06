<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('transaksi_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('ticket_id');
            $table->unsignedInteger('jumlah_tiket')->default(1);
            $table->decimal('total_harga', 10, 2);
            $table->string('status')->default('pending');
            $table->dateTime('payment_date')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('ticket_id')->references('ticket_id')->on('tickets');
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};