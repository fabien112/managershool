<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJoinToCyclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('classes', 'cycles_id')) {
            Schema::table('classes', function (Blueprint $table) {
                $table->unsignedBigInteger('cycles_id')->nullable(); // Par exemple
            });
        }
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('classes', 'cycles_id')) {
            Schema::table('classes', function (Blueprint $table) {
                $table->dropColumn('cycles_id');
            });
        }
    }
}
