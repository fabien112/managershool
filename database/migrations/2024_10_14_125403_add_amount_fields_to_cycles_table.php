<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAmountFieldsToCyclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cycles', function (Blueprint $table) {
            // $table->float('amountlieucontriexg')->nullable(); // Nouveau champ
            // $table->float('amountlieucontripar')->nullable(); // Nouveau champ
            // $table->float('amountlieufraistimbre')->nullable(); // Nouveau champ
            // $table->float('amountlieufraisexam')->nullable(); // Nouveau champ
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cycles', function (Blueprint $table) {
            //
        });
    }
}
