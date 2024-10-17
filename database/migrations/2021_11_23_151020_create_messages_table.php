<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classe_id')->constrained()->default('NULL')->onDelete('cascade');
            $table->string('object')->nullable();
            $table->longText('commentaires')->nullable();
            $table->string('destinataires')->nullable();
            $table->string('document')->nullable();
            $table->string('precis')->default("0");
            $table->string('statut')->default("0");
            $table->string('type')->default("1");
            $table->dateTime('date')->nullable();
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
        Schema::dropIfExists('messages');
    }
}
