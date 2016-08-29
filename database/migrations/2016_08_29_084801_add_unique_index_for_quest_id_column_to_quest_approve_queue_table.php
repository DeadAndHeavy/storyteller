<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUniqueIndexForQuestIdColumnToQuestApproveQueueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quest_approve_queue', function (Blueprint $table) {
            $table->unique('quest_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quest_approve_queue', function (Blueprint $table) {
            $table->dropIndex('quest_id');
        });
    }
}
