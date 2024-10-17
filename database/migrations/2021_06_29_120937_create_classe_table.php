<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClasseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('libelleClasse')->default("NULL");
            $table->string('codeEtabClasse')->default("NULL");
            $table->integer('statutClasse')->default("0");
            $table->date('datecreaClasse')->nullable();
            $table->string('sessionClasse')->default("NULL");
            $table->integer('sectionClasse')->default("0");
            $table->string('inscription_Classe')->default("NULL");
            $table->integer('scolarite_Classe')->default("0");
            $table->integer('scolariteaff_Classe')->default("0");
            $table->integer('reinscription_Classe')->default("0");
            $table->string('type_Classe')->default("NULL");
            $table->integer('niveau_Classe')->default("0");
            $table->integer('cycle_Classe')->default("0");
            $table->string('libellecycle_Classe')->default("NULL");
            $table->string('principale_Classe')->default("NULL");
            $table->integer('order_Classe')->default("0");
            $table->integer('mixte_Classe')->default("0");
            $table->string('emp_Classe')->default("NULL");
            $table->integer('createby_Classe')->default("0");
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
        Schema::dropIfExists('classe');
    }
}
