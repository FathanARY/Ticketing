<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
    {
    public function up()
    {
        Schema::create('speakers', function (Blueprint $table) {
            $table->bigIncrements('speaker_id');
            $table->unsignedBigInteger('event_id');
            $table->string('nama_speaker');
            $table->text('bio')->nullable();
            $table->string('foto')->nullable();
            $table->boolean('is_revealed')->default(false);
            $table->dateTime('reveal_date')->nullable();
            $table->timestamps();

            $table->foreign('event_id')->references('event_id')->on('events')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('speakers');
    }
};