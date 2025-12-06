<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->bigIncrements('ticket_id');
            $table->unsignedBigInteger('event_id');
            $table->string('jenis_tiket');
            $table->decimal('harga', 10, 2)->default(0.00);
            $table->unsignedInteger('stok')->default(0);
            $table->timestamps();

            $table->foreign('event_id')->references('event_id')->on('events')->onDelete('cascade');
         });
    }

    public function down()
    {
        Schema::dropIfExists('tickets');
    }
};