<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('etablissement_id')->constrained()->nullable()->onDelete('cascade');
            $table->string('libelle_sess')->nullable();
            $table->string('codeEtab_sess')->nullable();
            $table->string('encours_sess')->nullable();
            $table->string('status_sess')->nullable();
            $table->string('type_sess')->nullable();
            $table->string('datedeb_sess')->nullable();
            $table->string('datefin_sess')->nullable();
            $table->string('celendar_sess')->nullable();
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
        Schema::dropIfExists('sessions');
    }
}
