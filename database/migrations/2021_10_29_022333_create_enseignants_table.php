<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnseignantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enseignants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->nullable()->onDelete('cascade');
            $table->string('nom')->nullable();
            $table->string('prenom')->nullable();
            $table->integer('tel')->default("0");
            $table->string('email')->nullable();
            $table->string('sexe')->nullable();
            $table->integer('statut')->default("1");
            $table->string('nationalite')->nullable();
            $table->string('situation')->nullable();
            $table->string('matricule')->nullable();
            $table->string('salaire')->nullable();
            $table->string('dateEmbauche')->nullable();
            $table->integer('type')->default("1");
            $table->string('codeEtab')->nullable();
            $table->string('session')->nullable();
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
        Schema::dropIfExists('enseignants');
    }
}
