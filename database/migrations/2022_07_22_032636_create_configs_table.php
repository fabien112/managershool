<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configs', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('etablissements_id')->constrained()->nullable()->onDelete('cascade');
            $table->string('header')->nullable();
            $table->string('footer')->nullable();
            $table->float('abscenceMax')->nullable();
            $table->float('MoyenneMin')->nullable();
            $table->float('MoyenneTH')->nullable();
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
        Schema::dropIfExists('configs');
    }
}
