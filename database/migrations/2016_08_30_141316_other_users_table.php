<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OtherUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('other_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('sign')->nullable();
            $table->string('sex')->nullable();
            $table->string('birth_time')->nullable();
            $table->string('birth_time_hour')->nullable();
            $table->string('birth_time_minute')->nullable();
            $table->enum('birth_time_type', ['AM', 'PM']);
            $table->boolean('birth_time_sunrise');
            $table->smallInteger('birth_day')->nullable();
            $table->string('birth_month')->nullable();
            $table->integer('birth_year')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('s_c_state')->nullable();
            $table->string('s_c_city')->nullable();
            $table->string('s_c_country')->nullable();
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
        //
    }
}
