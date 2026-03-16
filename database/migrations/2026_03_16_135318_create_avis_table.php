<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvisTable extends Migration
{
    public function up()
    {
        Schema::create('avis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')->constrained('reservations')->onDelete('cascade');
            $table->foreignId('passager_id')->constrained('passagers')->onDelete('cascade');
            $table->foreignId('conducteur_id')->constrained('conducteurs')->onDelete('cascade');
            $table->integer('note')->unsigned();
            $table->text('commentaire')->nullable();
            $table->boolean('signale')->default(false);
            $table->timestamp('date_creation')->useCurrent();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('avis');
    }
}