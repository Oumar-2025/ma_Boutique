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
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employe_id')->constrained()->onDelete('cascade');
            $table->decimal('montant', 10, 0);
            $table->date('date_paiement');
            $table->string('type')->default('salaire'); // ou 'prime', 'bonus', etc.
            $table->foreignId('boutique_id')->nullable()->constrained('boutiques')->onDelete('set null');
            $table->foreignId('annexe_id')->nullable()->constrained('annexes')->onDelete('set null');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // Qui a validé/paié
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
        Schema::dropIfExists('paiements');
    }
};
