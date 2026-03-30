<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConducteursTable extends Migration
{
    public function up()
    {
      Schema::create('conducteurs', function (Blueprint $table) {
    $table->id();
    $table->foreignId('utilisateur_id')->constrained('utilisateurs')->onDelete('cascade');
    $table->string('numero_permis');
    $table->float('note_moyenne')->default(0);
    $table->boolean('est_bloque')->default(false); 
    $table->timestamps();
});
    }

    public function down()
    {
        Schema::dropIfExists('conducteurs');
    }
}