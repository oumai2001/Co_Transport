<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrajetsTable extends Migration
{
    public function up()
    {
        Schema::create('trajets', function (Blueprint $table) {
            $table->id();

            $table->foreignId('conducteur_id')
                  ->constrained('conducteurs')
                  ->onDelete('cascade');

            $table->foreignId('vehicule_id')
                  ->constrained('vehicules');

            $table->foreignId('ville_depart_id')
                  ->constrained('villes');

            $table->foreignId('ville_arrivee_id')
                  ->constrained('villes');

            $table->dateTime('date_depart');
            $table->dateTime('date_arrivee');

            $table->decimal('prix', 10, 2);

           $table->enum('statut', [
    'en_attente',  
    'programme',    
    'en_cours',     
    'termine',     
    'annule',      
    'refuse'       
])->default('en_attente');

            $table->integer('places_disponibles');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('trajets');
    }
}