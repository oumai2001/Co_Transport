<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date_reservation')->default(now());
            $table->integer('nombre_places');
            $table->float('prix_unitaire');
            $table->float('prix_total');
            $table->enum('statut', ['confirmée', 'en attente', 'annulée'])->default('en attente');
            $table->text('commentaire')->nullable();
            $table->foreignId('passager_id')->constrained('passagers')->onDelete('cascade');
            $table->foreignId('trajet_id')->constrained('trajets')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};