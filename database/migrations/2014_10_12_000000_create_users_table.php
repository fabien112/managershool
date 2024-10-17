<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->default("NULL");
            $table->string('prenom')->default("NULL");
            $table->date('datenais')->nullable();
            $table->string('lieunais')->default("NULL");
            $table->string('genre')->default("M");
            $table->string('telephone')->default("NULL");
            $table->string('email')->default("NULL");
            $table->string('fonction')->default("NULL");
            $table->string('login')->default("NULL");
            $table->string('password')->default("NULL");
            $table->boolean('statut')->default(0);
            $table->string('photo')->default("NULL");
            $table->string('online')->default(0);
            $table->string('type')->default("NULL");
            $table->string('adresse')->default("NULL");
            $table->string('telbureau')->default("NULL");
            $table->string('lieuhabitqtion')->default("NULL");
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
