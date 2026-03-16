<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConducteursTable extends Migration
{
    public function up()
    {
        Schema::create('conducteurs', function (Blueprint $table) {
            $table->id(); // id : int (hérité de Utilisateur)
            $table->string('nom'); // nom : string (hérité)
            $table->string('email')->unique(); // email : string (hérité)
            $table->string('mot_de_passe'); // motDePasse : string (hérité)
            $table->string('telephone'); // telephone : string (hérité)
            $table->string('numero_permis'); // numeroPermis : string (spécifique Conducteur)
            $table->float('note_moyenne')->nullable(); // noteMoyenne : float (spécifique Conducteur)
            $table->boolean('est_bloque')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('conducteurs');
    }
}