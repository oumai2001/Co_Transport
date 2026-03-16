<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id(); // id : int
            $table->foreignId('passager_id')->constrained('passagers')->onDelete('cascade'); // passager_id : relation avec Passager (1 passager effectue 0..* reservations)
            $table->foreignId('trajet_id')->constrained('trajets')->onDelete('cascade'); // trajet_id : relation avec Trajet (1 reservation concerne 1 trajet)
            $table->integer('nombre_places'); // nombrePlaces : int
            $table->decimal('prix_total', 10, 2); // prixTotal : float
            $table->enum('statut', ['confirmee', 'en_attente', 'annulee'])->default('en_attente'); // statut : enum (statusR)
            $table->datetime('date_reservation'); // dateReservation : datetime
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}