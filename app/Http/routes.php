<?php

Route::group(['prefix' => 'api/v1'], function () {
    Route::get('quest', 'Api\QuestController@index');
    Route::post('quest', 'Api\QuestController@store');
});

Route::auth();

Route::group(['namespace' => 'Web'], function() {

    Route::get('/', 'QuestController@index')->name('public_quests');
    Route::get('/quest', 'QuestController@index');
    Route::get('/quest/{questId}', 'QuestController@show')->name('quest_page')->where('questId', '[0-9]+');
    Route::get('/quest/{questId}/play', 'ScenarioController@play')->name('play_quest');
    Route::get('/quest/{questId}/finish', 'ScenarioController@finish')->name('finish_quest');
    Route::get('/scenario/renderNewEpisodeStep', 'ScenarioController@renderNewScenarioStep');
    Route::get('/quest/comment/renderQuestComment', 'QuestController@renderQuestComment');

    Route::group(['middleware' => 'auth'], function () {
        Route::get('/quest/own', 'QuestController@ownQuests')->name('own_quests');
        Route::get('/quest/create', 'QuestController@create')->name('create_quest');
        Route::post('/quest', 'QuestController@store');
        Route::get('/quest/{questId}/edit', 'QuestController@edit')->name('edit_quest');
        Route::patch('/quest/{questId}', 'QuestController@update');
        Route::delete('/quest/{questId}', 'QuestController@destroy')->name('delete_quest');
        Route::post('/quest/{questId}/submit_for_approving', 'ApproveController@submitForApproving')->name('submit_for_approving');
        Route::post('/quest/{questId}/like','QuestController@like')->name('like_quest');
        Route::post('/quest/{questId}/dislike','QuestController@dislike')->name('dislike_quest');
        Route::post('/quest/{questId}/comment','QuestController@addComment')->name('comment_quest');
        Route::patch('/quest/{questId}/comment/{commentId}','QuestController@updateComment')->name('update_quest_comment');
        Route::delete('/quest/{questId}/comment/{commentId}', 'QuestController@deleteComment')->name('delete_quest_comment');
        Route::get('/quest/comment/renderQuestCommentForm', 'QuestController@renderQuestCommentForm');

        Route::get('/quest/{questId}/episode', 'EpisodeController@index')->name('all_episodes');
        Route::get('/quest/{questId}/episode/create', 'EpisodeController@create')->name('create_episode');
        Route::post('/quest/{questId}/episode', 'EpisodeController@store')->name('store_episode');
        Route::get('/episode/renderEpisodeAction', 'EpisodeController@renderEpisodeAction');
        Route::get('/quest/{questId}/episode/{episodeId}/edit', 'EpisodeController@edit')->name('edit_episode');
        Route::patch('/quest/{questId}/episode/{episodeId}', 'EpisodeController@update')->name('update_episode');
        Route::delete('/quest/{id}/episode/{episodeId}', 'EpisodeController@destroy')->name('delete_episode');

        Route::get('/quest/{questId}/scenario', 'ScenarioController@index')->name('scenario');
        Route::post('/quest/{questId}/scenario/save', 'ScenarioController@save')->name('save_scenario');
        Route::get('/scenario/renderNewStep', 'ScenarioController@renderNewStep');
        Route::post('/quest/{questId}/scenario', 'ScenarioController@saveLogic')->name('save_scenario');
        Route::post('/quest/{questId}/scenario/saveVariables', 'ScenarioController@saveVariables')->name('save_variables');
        Route::delete('/quest/{questId}/variable/{variableId}', 'ScenarioController@destroyVariable')->name('delete_quest_variable');
        Route::get('/quest/{questId}/variable/{variableId}/edit', 'ScenarioController@editVariable')->name('edit_quest_variable');
        Route::patch('/quest/{questId}/variable/{variableId}', 'ScenarioController@updateVariable')->name('update_quest_variable');

        Route::get('/quest/{questId}/logic', 'QuestLogicController@index')->name('quest_logic_index');
        Route::get('/quest/{questId}/variable/create', 'QuestLogicController@createQuestVariable')->name('create_quest_variable');
        Route::post('/quest/{questId}/variable', 'QuestLogicController@storeQuestVariable')->name('store_quest_variable');

        Route::get('/variable/renderVariable', 'QuestLogicController@renderVariable');

        Route::group(['middleware' => 'admin'], function () {
            Route::get('/quest_approving', 'ApproveController@index')->name('quests_for_approving');
            Route::patch('/quest_approving/{questId}/approve', 'ApproveController@approve')->name('approve_quest');
            Route::patch('/quest_approving/{questId}/reject', 'ApproveController@reject')->name('reject_quest');
        });
    });
});