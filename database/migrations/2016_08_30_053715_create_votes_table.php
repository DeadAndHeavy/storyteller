<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quest_id')->unsigned();
            $table->foreign('quest_id')->references('id')->on('quests')->onDelete('cascade');
            $table->integer('user_id');
            $table->integer('type');
            $table->unique(['quest_id', 'user_id']);
            $table->index('quest_id');
            $table->index('user_id');
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
        Schema::drop('votes');
    }
}
