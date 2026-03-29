<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiculesTable extends Migration
{
    public function up()
    {
        Schema::create('vehicules', function (Blueprint $table) {
            $table->id();

            $table->string('immatriculation')->unique();
            $table->string('marque');
            $table->string('modele');
            $table->integer('capacite');

            $table->enum('statut', [
                'disponible',
                'maintenance',
                'en_trajet'
            ])->default('disponible');

            $table->foreignId('conducteur_id')
                  ->constrained('conducteurs')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vehicules');
    }
}