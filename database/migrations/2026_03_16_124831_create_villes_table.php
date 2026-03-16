<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVillesTable extends Migration
{
    public function up()
    {
        Schema::create('villes', function (Blueprint $table) {
            $table->id(); // id : int (clé primaire)
            $table->string('nom'); // nom : string
            $table->string('code_postal'); // codePostal : string
            $table->string('pays')->default('France'); // pays : string
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('villes');
    }
}