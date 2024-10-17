<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoyenneAnnuellesTable extends Migration
{
    /**
     * Exécute la migration.
     *
     * @return void
     */
    public function up()
    {
        // Vérifie si la table 'moyenne_annuelles' existe déjà
        if (!Schema::hasTable('moyenne_annuelles')) {
            Schema::create('moyenne_annuelles', function (Blueprint $table) {
                $table->id();
                $table->foreignId('classe_id')->nullable()->constrained()->onDelete('cascade');
                $table->foreignId('student_id')->nullable()->constrained()->onDelete('cascade');
                $table->double('valeur')->nullable();
                $table->string('codeEtab')->nullable();
                $table->string('session')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Annule la migration.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('moyenne_annuelles');
    }
}
