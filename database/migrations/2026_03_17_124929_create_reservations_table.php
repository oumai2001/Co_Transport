<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('passager_id')
                  ->constrained('passagers')
                  ->onDelete('cascade');

            $table->foreignId('trajet_id')
                  ->constrained('trajets')
                  ->onDelete('cascade');

            $table->integer('nombre_places');

            $table->decimal('prix_total', 10, 2);

            $table->enum('statut', [
                'confirmee',
                'en_attente',
                'annulee'
            ])->default('en_attente');

            $table->dateTime('date_reservation');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}