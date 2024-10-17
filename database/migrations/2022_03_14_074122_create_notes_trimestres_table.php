<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotesTrimestresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notes_trimestres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trimestre_id')->constrained()->nullable()->onDelete('cascade');
            $table->foreignId('matiere_id')->constrained()->nullable()->onDelete('cascade');
            $table->integer('cat_id')->nullable();
            $table->foreignId('classe_id')->constrained()->nullable()->onDelete('cascade');
            $table->foreignId('student_id')->constrained()->nullable()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->nullable()->onDelete('cascade');
            $table->double('valeur')->nullable();
            $table->string('mention')->nullable();
            $table->double('status')->nullable();
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
        Schema::dropIfExists('notes_trimestres');
    }
}
