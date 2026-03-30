<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePassagersTable extends Migration
{
    public function up()
    {
        Schema::create('passagers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('utilisateur_id')
                  ->constrained('utilisateurs')
                  ->onDelete('cascade');

            $table->boolean('est_bloque')->default(false);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('passagers');
    }
}