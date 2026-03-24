<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trajets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ville_depart_id')->constrained('villes');
            $table->foreignId('ville_arrivee_id')->constrained('villes');
            $table->string('adresse_depart')->nullable();
            $table->string('adresse_arrivee')->nullable();
            $table->dateTime('date_depart');
            $table->dateTime('date_arrivee')->nullable();
            $table->float('prix');
            $table->integer('places_totales');
            $table->integer('places_disponibles');
            $table->enum('statut', ['programmé', 'en cours', 'terminé', 'annulé'])->default('programmé');
            $table->foreignId('conducteur_id')->constrained('conducteurs');
            $table->foreignId('vehicule_id')->nullable()->constrained('vehicules');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trajets');
    }
};