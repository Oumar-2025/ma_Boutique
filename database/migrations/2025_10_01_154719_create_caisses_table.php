<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caisses', function (Blueprint $table) {
            $table->id();

            // type : entrée ou sortie
            $table->enum('type', ['entrée', 'sortie']);

            // source du mouvement (salaire, vente, dépense, achat, etc.)
            $table->enum('source', ['vente', 'paiement_salaire', 'depense', 'achat', 'autre']);

            $table->decimal('montant', 10, 0);

            $table->string('description')->nullable();
            $table->date('date_mouvement');

            // pour rattacher si nécessaire
            $table->foreignId('paiement_id')->nullable()->constrained('paiements')->onDelete('set null');
            $table->foreignId('vente_id')->nullable()->constrained('ventes')->onDelete('set null');
            $table->foreignId('depense_id')->nullable()->constrained('depenses')->onDelete('set null');
            $table->foreignId('achat_id')->nullable()->constrained('achats')->onDelete('set null');

            $table->foreignId('boutique_id')->nullable()->constrained('boutiques')->onDelete('cascade');
            $table->foreignId('annexe_id')->nullable()->constrained('annexes')->onDelete('set null');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('caisses');
    }
};
