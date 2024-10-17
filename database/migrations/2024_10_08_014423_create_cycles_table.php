<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCyclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cycles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            // Lieu de paiement pour contre-extrait et montant
            $table->string('lieucontriexg')->nullable();
            $table->float('amountlieucontriexg')->nullable();

            // Lieu de paiement pour parent et montant
            $table->string('lieucontripar')->nullable();
            $table->float('amountlieucontripar')->nullable();

            // Lieu de paiement pour frais timbre et montant
            $table->string('lieufraistimbre')->nullable();
            $table->float('amountlieufraistimbre')->nullable();

            // Lieu de paiement pour frais examen et montant
            $table->string('lieufraisexam')->nullable();
            $table->float('amountlieufraisexam')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cycles');
    }
}
