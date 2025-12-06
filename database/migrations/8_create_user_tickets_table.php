<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_tickets', function (Blueprint $table) {
            $table->bigIncrements('user_ticket_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('transaksi_id');
            $table->string('kode_tiket')->unique();
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('transaksi_id')->references('transaksi_id')->on('transactions')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_tickets');
    }
};