<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevoirsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devoirs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('matiere_id')->constrained()->nullable()->onDelete('cascade');
            $table->foreignId('classe_id')->constrained()->nullable()->onDelete('cascade');
            $table->foreignId('enseignants_id')->constrained()->nullable()->onDelete('cascade');
            $table->string('libelle')->nullable();
            $table->date('dateLimite')->nullable();
            $table->string('document')->nullable();
            $table->string('instructions')->nullable();
            $table->integer('statut')->nullable()->default(0);
            $table->integer('verouiller')->nullable()->default(0);
            $table->string('support')->nullable();
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
        Schema::dropIfExists('devoirs');
    }
}
