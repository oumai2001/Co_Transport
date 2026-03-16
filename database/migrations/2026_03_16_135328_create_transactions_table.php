<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('paiement_id')->constrained('paiements')->onDelete('cascade');
            $table->decimal('montant', 10, 2);
            $table->enum('type', ['depense', 'remboursement', 'gain']);
            $table->enum('statut', ['en_attente', 'complete', 'echoue'])->default('en_attente');
            $table->string('description');
            $table->timestamp('date_creation')->useCurrent();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}