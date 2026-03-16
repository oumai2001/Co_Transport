<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaiementsTable extends Migration
{
    public function up()
    {
        Schema::create('paiements', function (Blueprint $table) {
            $table->id(); // id : int
            $table->foreignId('reservation_id')->constrained('reservations')->onDelete('cascade'); // reservation_id : relation avec Reservation (1 paiement correspond a 1 reservation)
            $table->decimal('montant', 10, 2); // montant : float
            $table->datetime('date_paiement'); // datePaiement : datetime
            $table->enum('mode_paiement', ['carte', 'especes'])->default('carte'); // modePaiement : enum (modeP)
            $table->enum('statut', ['paye', 'rembourse', 'en_attente'])->default('en_attente'); // statut : enum (statusP)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('paiements');
    }
}