<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisciplinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disciplines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->nullable()->onDelete('cascade');
            $table->foreignId('classe_id')->constrained()->nullable()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->nullable()->onDelete('cascade');
            // $table->datetime('dateHeure')->nullable();
            $table->date('date')->nullable();
            $table->time('heure')->nullable();
            $table->string('duree')->nullable();
            $table->text('motif')->nullable();
            $table->string('mois_id')->nullable();
            $table->string('evaluation_id')->nullable();
            $table->string('type')->nullable();
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
        Schema::dropIfExists('disciplines');
    }
}
