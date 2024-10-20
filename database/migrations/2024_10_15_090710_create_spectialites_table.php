<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpectialitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spectialites', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->nullable();
            $table->string('description')->nullable();
            $table->foreignId('fillieres_id')->constrained()->nullable()->onDelete('cascade');
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
        Schema::dropIfExists('spectialites');
    }
}
