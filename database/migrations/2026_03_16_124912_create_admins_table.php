<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id(); // id : int (hérité de Utilisateur)
            $table->string('nom'); // nom : string (hérité)
            $table->string('email')->unique(); // email : string (hérité)
            $table->string('mot_de_passe'); // motDePasse : string (hérité)
            $table->string('telephone'); // telephone : string (hérité)
            $table->string('niveau_acces')->default('full'); // niveauAcces : string (spécifique Admin)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('admins');
    }
}