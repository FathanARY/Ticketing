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
        Schema::create('events', function (Blueprint $table) {
            $table->id('event_id');
            $table->string('nama_event');
            $table->text('deskripsi')->nullable();
            $table->dateTime('tanggal_event')->nullable();
            $table->string('lokasi')->nullable();
            $table->text('maps_embed')->nullable();
            $table->timestamps(); // ini akan membuat created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
