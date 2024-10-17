<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoteAnnuellesTable extends Migration
{
    /**
     * Exécute la migration.
     *
     * @return void
     */
    public function up()
    {
        // Vérifie si la table 'note_annuelles' existe déjà
        if (!Schema::hasTable('note_annuelles')) {
            Schema::create('note_annuelles', function (Blueprint $table) {
                $table->id();
                $table->foreignId('matiere_id')->nullable()->constrained()->onDelete('cascade');
                $table->integer('cat_id')->nullable();
                $table->foreignId('classe_id')->nullable()->constrained()->onDelete('cascade');
                $table->foreignId('student_id')->nullable()->constrained()->onDelete('cascade');
                $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('note_annuelles');
    }
}
