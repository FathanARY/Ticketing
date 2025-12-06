<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('notif_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('transaksi_id')->nullable();
            $table->string('jenis_notif');
            $table->string('status')->default('unread');
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('transaksi_id')->references('transaksi_id')->on('transactions')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};