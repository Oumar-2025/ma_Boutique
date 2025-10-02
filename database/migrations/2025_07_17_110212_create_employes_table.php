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
        Schema::create('employes', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom')->nullable();
            $table->string('telephone')->nullable();
            $table->string('email')->unique();
            $table->string('poste')->nullable(); // caissier, gérant, etc.
            $table->decimal('salaire', 10, 0)->nullable();
            $table->string('nomurg')->nullable();
            $table->string('telurg')->nullable();
            $table->string('relation')->nullable();
            // $table->foreignId('poste_id')->nullable()->constrained('postes')->onDelete('set null');
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
        Schema::dropIfExists('employes');
    }
};
