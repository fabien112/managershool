<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDestinatairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('destinataires', function (Blueprint $table) {
            $table->id();
            $table->foreignId('messages_id')->constrained()->nullable()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->nullable()->onDelete('cascade');
            $table->string('codeEtab')->nullable();
            $table->string('session')->nullable();
            $table->string('liste_destinataire')->nullable();
            $table->string('type_destinataire')->default(NULL);
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
        Schema::dropIfExists('destinataires');
    }
}
