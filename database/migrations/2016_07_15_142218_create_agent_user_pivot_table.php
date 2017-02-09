<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgentUserPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('agent_id')->unsigned()->index();
            $table->foreign('agent_id')->references('id')->on('agents')->onDelete('cascade');
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('agent_status');
            $table->string('customer_status');
            $table->enum('chat_status', ['Draft', 'Pending', 'Active', 'Completed', 'Cancelled', 'Archived']);
        //    $table->primary(['agent_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('agent_user');
    }
}
