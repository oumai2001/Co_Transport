<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiculesTable extends Migration
{
    public function up()
    {
        Schema::create('vehicules', function (Blueprint $table) {
            $table->id(); // id : int
            $table->string('immatriculation')->unique(); // immatriculation : string
            $table->string('marque'); // marque : string
            $table->string('modele'); // modele : string
            $table->integer('capacite'); // capacite : int
            $table->enum('statut', ['disponible', 'maintenance', 'en_trajet'])->default('disponible'); // statut : enum
            $table->foreignId('conducteur_id')->constrained('conducteurs')->onDelete('cascade'); // relation avec Conducteur (1 conducteur possède 0..* vehicules)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vehicules');
    }
}