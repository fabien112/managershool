<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatieresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matieres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classe_id')->constrained()->nullable()->onDelete('cascade');
            $table->foreignId('enseignants_id')->constrained()->nullable()->onDelete('cascade');
            $table->string('libelle')->nullable();
            $table->string('cathegory_id')->nullable();
            $table->string('codeEtab')->nullable();
            $table->string('session')->default("0");
            $table->string('affected')->default("0");
            $table->float('coef')->default("0");
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
        Schema::dropIfExists('matieres');
    }
}
