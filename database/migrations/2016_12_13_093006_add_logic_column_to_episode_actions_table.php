<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLogicColumnToEpisodeActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('episode_actions', function (Blueprint $table) {
            $table->text('logic')
                ->default('')
                ->after('episode_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('episode_actions', function (Blueprint $table) {
            $table->dropColumn('logic');
        });
    }
}
