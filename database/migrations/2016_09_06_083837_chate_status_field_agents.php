<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChateStatusFieldAgents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('agents', function($table)
        {
            $table->dropColumn('status');
        });
        Schema::table('agents', function($table)
        {
            $table->enum('status', ['Online', 'Offline'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
