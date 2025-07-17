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
        Schema::create('ventes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->decimal('total', 10, 0);
            $table->date('date_vente');
            $table->string('mode_paiement')->default('espèces');
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
        Schema::dropIfExists('ventes');
    }
};
