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
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
             $table->string('nom');
            $table->unsignedBigInteger('categorie_id');
            $table->string('code_barre')->nullable();
            $table->decimal('prix_achat', 10, 0);
            $table->decimal('prix_vente', 10, 0);
            $table->integer('stock')->default(0);
            $table->string('image')->nullable();
            $table->foreign('categorie_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreignId('boutique_id')->nullable()->constrained('boutiques')->onDelete('set null');
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
        Schema::dropIfExists('produits');
    }
};
