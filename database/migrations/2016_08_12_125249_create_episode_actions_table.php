<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEpisodeActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('episode_actions', function (Blueprint $table) {
            $table->increments('id');
            $table->text('content');
            $table->integer('target_episode_id');
            $table->integer('episode_id')->unsigned();
            $table->foreign('episode_id')->references('id')->on('episodes');
            $table->index('episode_id');
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
        Schema::drop('episode_actions');
    }
}
