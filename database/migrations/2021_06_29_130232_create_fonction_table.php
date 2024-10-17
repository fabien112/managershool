<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFonctionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fonction', function (Blueprint $table) {
            $table->id();
            $table->string('libelleFonc')->default("NULL");
            $table->string('valueFonc')->default("NULL");
            $table->string('codeEtabFonc')->default("NULL");
            $table->string('EtabFonc')->default("NULL");
            $table->integer('statutFonc')->default("0");
            $table->integer('createbybyFonc')->default("0");
            $table->date('datecreaFonc')->nullable();
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
        Schema::dropIfExists('fonction');
    }
}
