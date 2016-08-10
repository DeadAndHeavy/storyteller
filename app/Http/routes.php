<?php

Route::group(['prefix' => 'api/v1'], function () {
    Route::get('quest', 'Api\QuestController@index');
    Route::post('quest', 'Api\QuestController@store');
});

Route::auth();

Route::get('/', 'HomeController@index');

Route::get('/quest', 'Web\QuestController@index');
Route::get('/quest/own', 'Web\QuestController@ownQuests');
Route::get('/quest/create', 'Web\QuestController@create');
Route::get('/quest/addEpisodeHtml', 'Web\QuestController@addEpisodeHtml');
Route::post('/quest/store', 'Web\QuestController@store');