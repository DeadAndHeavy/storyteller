<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestApproveQueueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quest_approve_queue', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quest_id')->unsigned();
            $table->foreign('quest_id')->references('id')->on('quests')->onDelete('cascade');
            $table->integer('approve_status');
            $table->string('message');
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
        Schema::drop('quest_approve_queue');
    }
}
