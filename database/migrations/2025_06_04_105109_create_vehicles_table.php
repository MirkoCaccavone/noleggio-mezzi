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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // car, scooter, bike, etc.
            $table->string('brand'); // marca
            $table->string('model'); //modello
            $table->string('plate')->unique(); //targa
            $table->text('description')->nullable(); // descrizione
            $table->decimal('price_per_day', 8, 2); //prezzo al giorno
            $table->boolean('available')->default(true); //disponibile
            $table->string('image')->nullable();  // immagine
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
