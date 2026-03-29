<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaiementsTable extends Migration
{
    public function up()
    {
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();

            $table->foreignId('reservation_id')
                  ->constrained('reservations')
                  ->onDelete('cascade');

            $table->decimal('montant', 10, 2);

            $table->dateTime('date_paiement');

            $table->enum('mode_paiement', [
                'carte',
                'especes'
            ])->default('carte');

            $table->enum('statut', [
                'paye',
                'rembourse',
                'en_attente'
            ])->default('en_attente');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('paiements');
    }
}