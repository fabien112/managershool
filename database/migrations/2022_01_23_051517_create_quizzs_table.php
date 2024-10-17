<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizzsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quizzs', function (Blueprint $table) {

            $table->id();
            $table->foreignId('matiere_id')->constrained()->nullable()->onDelete('cascade');
            $table->foreignId('classe_id')->constrained()->nullable()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->nullable()->onDelete('cascade');
            $table->string('libelle')->nullable();
            $table->string('consigne')->nullable();
            $table->string('instruction')->nullable();
            $table->datetime('date')->nullable();
            $table->time('duree')->nullable();
            $table->string('verrouiller')->nullable();
            $table->string('statut')->nullable();
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
        Schema::dropIfExists('quizzs');
    }
}
