<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToCyclesTable extends Migration
{
    /**
     * Exécute la migration.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cycles', function (Blueprint $table) {
            // $table->string('lieucontriexg')->nullable()->after('id');
            // $table->string('lieucontripar')->nullable()->after('lieucontriexg');
            // $table->string('lieufraistimbre')->nullable()->after('lieucontripar');
            // $table->string('lieufraisexam')->nullable()->after('lieufraistimbre');
            $table->string('designation')->nullable()->after('lieufraisexam'); // Ajout de la colonne designation
        });
    }

    /**
     * Annule la migration.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cycles', function (Blueprint $table) {
            $table->dropColumn(['lieucontriexg', 'lieucontripar', 'lieufraistimbre', 'lieufraisexam', 'designation']); // Suppression de la colonne designation
        });
    }
}
