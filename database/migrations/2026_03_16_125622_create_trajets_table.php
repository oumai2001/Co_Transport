<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrajetsTable extends Migration
{
    public function up()
    {
        Schema::create('trajets', function (Blueprint $table) {
            $table->id(); // id : int
            $table->foreignId('conducteur_id')->constrained('conducteurs')->onDelete('cascade'); // conducteur_id : relation avec Conducteur (1 conducteur propose 0..* trajets)
            $table->foreignId('vehicule_id')->constrained('vehicules'); // vehicule_id : relation avec Vehicule (1 trajet utilise 1 vehicule)
            $table->foreignId('ville_depart_id')->constrained('villes'); // villeDepart_id : relation avec Ville (depart)
            $table->foreignId('ville_arrivee_id')->constrained('villes'); // villeArrivee_id : relation avec Ville (arrivee)
            $table->datetime('date_depart'); // dateDepart : datetime
            $table->datetime('date_arrivee'); // dateArrivee : datetime
            $table->decimal('prix', 10, 2); // prix : float
            $table->enum('status', ['programme', 'en_cours', 'termine', 'annule'])->default('programme'); // status : enum (statusT)
            $table->integer('places_disponibles'); // placesDisponibles : int
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('trajets');
    }
}