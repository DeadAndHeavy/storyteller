<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEpisodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('episodes', function (Blueprint $table) {
            $table->increments('id');
            $table->text('content')->default('');
            $table->integer('quest_id')->unsigned();
            $table->foreign('quest_id')->references('id')->on('quests');
            $table->integer('episode_number');
            $table->unique(['quest_id', 'episode_number']);
            $table->index('quest_id');
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
        Schema::drop('episodes');
    }
}
