<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEtablissementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etablissements', function (Blueprint $table) {
            $table->id();
            $table->string('codeEtab')->default("NULL");
            $table->string('libelleEtab')->default("NULL");
            $table->string('sigleEtab')->default("NULL");
            $table->string('sloganEtab')->default("NULL");
            $table->string('emailEtab')->default("NULL");
            $table->string('principaltelEtab')->default("NULL");
            $table->string('secondairetelEtab')->default("NULL");
            $table->string('paysEtab')->default("NULL");
            $table->string('villeEtab')->default("NULL");
            $table->string('sitewebEtab')->default("NULL");
            $table->string('directeurEtab')->default("NULL");
            $table->string('principalteldirecteurEtab')->default("NULL");
            $table->string('adresseEtab')->default("NULL");
            $table->string('logoEtab')->default("NULL");
            $table->date('datecreationEtab')->nullable();
            $table->integer('createbyEtab')->default("0");
            $table->integer('typeEtab')->default("0");
            $table->string('mixteEtab')->default("0");
            $table->integer('groupstateEtab')->default("0");
            $table->integer('groupidEtab')->default("0");
            $table->string('groupnameEtab')->default("NULL");
            $table->integer('primaireEtab')->default("0");
            $table->date('datebuildEtab')->nullable();
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
        Schema::dropIfExists('etablissement');
    }
}
