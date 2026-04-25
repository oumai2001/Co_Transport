
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavorisTable extends Migration
{
    public function up()
    {
        Schema::create('favoris', function (Blueprint $table) {
            $table->id();

            $table->foreignId('passager_id')
                  ->constrained('passagers')
                  ->onDelete('cascade');

            $table->foreignId('conducteur_id')
                  ->constrained('conducteurs')
                  ->onDelete('cascade');

            $table->dateTime('date_ajout');

            $table->timestamps();

            $table->unique(['passager_id', 'conducteur_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('favoris');
    }
}