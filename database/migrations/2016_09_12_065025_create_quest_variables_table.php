<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestVariablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quest_variables', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quest_id')->unsigned();
            $table->foreign('quest_id')->references('id')->on('quests')->onDelete('cascade');
            $table->index('quest_id');
            $table->string('title');
            $table->string('type');
            $table->string('default_value');
            $table->boolean('track_state');
            $table->index('track_state');
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
        Schema::drop('quest_variables');
    }
}
