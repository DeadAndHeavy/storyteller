<?php

Route::group(['prefix' => 'api/v1'], function () {
    Route::get('quest', 'Api\QuestController@index');
    Route::post('quest', 'Api\QuestController@store');
});

Route::auth();

Route::get('/', 'HomeController@index');

Route::get('/quest', 'Web\QuestController@index');

Route::group(['namespace' => 'Web'], function() {
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/quest/own', 'QuestController@ownQuests');
        Route::get('/quest/create', 'QuestController@create')->name('create_quest');
        Route::post('/quest', 'QuestController@store');
        Route::get('/quest/{id}/edit', 'QuestController@edit')->name('edit_quest');
        Route::patch('/quest/{id}', 'QuestController@update');
        Route::delete('/quest/{id}', 'QuestController@destroy')->name('delete_quest');

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
        Route::post('/quest/{questId}/scenario', 'ScenarioController@save')->name('save_scenario');
    });
});