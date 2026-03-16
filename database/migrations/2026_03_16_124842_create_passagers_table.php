<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePassagersTable extends Migration
{
    public function up()
    {
        Schema::create('passagers', function (Blueprint $table) {
            $table->id(); // id : int (hérité de Utilisateur)
            $table->string('nom'); // nom : string (hérité)
            $table->string('email')->unique(); // email : string (hérité)
            $table->string('mot_de_passe'); // motDePasse : string (hérité)
            $table->string('telephone'); // telephone : string (hérité)
            $table->integer('points_fidelite')->default(0); // pointsFidelite : int (spécifique Passager)
            $table->boolean('est_bloque')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('passagers');
    }
}