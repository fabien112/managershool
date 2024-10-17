<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->nullable()->onDelete('cascade');
            $table->string('nomParent')->nullable();
            $table->string('prenomParent')->nullable();
            $table->integer('telParent')->default("0");
            $table->string('professionParent')->nullable();
            $table->string('cniParent')->nullable();
            $table->string('emailParent')->nullable();
            $table->string('sexeParent')->nullable();
            $table->integer('statutParent')->default("1");
            $table->string('nationaliteParent')->nullable();
            $table->string('addressParent')->nullable();
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
        Schema::dropIfExists('parents');
    }
}
