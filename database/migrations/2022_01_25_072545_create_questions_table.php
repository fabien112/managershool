<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {

            $table->id();
            $table->foreignId('quizz_id')->constrained()->nullable()->onDelete('cascade');
            $table->string('mode_reponse')->nullable();
            $table->string('libelle_question')->nullable();
            $table->string('resp_question')->nullable();
            $table->double('point')->nullable();
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
        Schema::dropIfExists('questions');
    }
}
