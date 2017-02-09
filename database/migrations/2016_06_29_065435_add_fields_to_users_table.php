<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function($table)
        {
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('sign')->nullable();
            $table->string('sex')->nullable();
            $table->string('birth_time')->nullable();
            $table->smallInteger('birth_day')->nullable();
            $table->string('birth_month')->nullable();
            $table->integer('birth_year')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('registration_token');
            $table->enum('status', ['Pending', 'Active', 'Blocked']);

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
