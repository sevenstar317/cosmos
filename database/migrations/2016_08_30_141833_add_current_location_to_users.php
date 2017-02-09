<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCurrentLocationToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function($table){
            $table->enum('birth_time_type', ['AM', 'PM']);
            $table->boolean('birth_time_sunrise');
            $table->string('country')->nullable();
            $table->string('c_state')->nullable();
            $table->string('c_city')->nullable();
            $table->string('c_country')->nullable();
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
