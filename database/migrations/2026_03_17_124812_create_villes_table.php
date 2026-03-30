<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVillesTable extends Migration
{
    public function up()
    {
        Schema::create('villes', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('code_postal');
            $table->string('pays')->default('France');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('villes');
    }
}