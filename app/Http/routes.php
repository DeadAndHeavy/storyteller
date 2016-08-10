<?php

Route::group(['prefix' => 'api/v1'], function () {
    Route::get('quest', 'Api\QuestController@index');
    Route::post('quest', 'Api\QuestController@store');
});

Route::auth();

Route::get('/home', 'HomeController@index');
Route::get('/quest/create', function() {
    return view('quest/create');
});