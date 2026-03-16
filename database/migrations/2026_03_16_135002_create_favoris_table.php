<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavorisTable extends Migration
{
    public function up()
    {
        Schema::create('favoris', function (Blueprint $table) {
            $table->id(); // id : int
            $table->foreignId('passager_id')->constrained('passagers')->onDelete('cascade'); // passager_id : relation avec Passager
            $table->foreignId('conducteur_id')->constrained('conducteurs')->onDelete('cascade'); // conducteur_id : relation avec Conducteur
            $table->datetime('date_ajout'); // dateAjout : datetime
            $table->timestamps();
            
            // Un passager ne peut ajouter un conducteur qu'une seule fois
            $table->unique(['passager_id', 'conducteur_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('favoris');
    }
}