<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->float('montant');
            $table->dateTime('date_paiement')->default(now());
            $table->enum('mode_paiement', ['carte', 'espèces'])->default('carte');
            $table->enum('statut', ['payé', 'remboursé', 'en attente'])->default('en attente');
            $table->string('transaction_id')->nullable()->unique();
            $table->foreignId('reservation_id')
                  ->constrained('reservations')
                  ->onDelete('cascade')
                  ->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};