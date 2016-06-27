<?php


Route::auth();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'FrontController@home');

    Route::get('maison-des-primates', 'FrontController@units');

    Route::get('singeries', 'FrontController@recruits');
    Route::post('singeries', 'FrontController@addRecruits');

    Route::get('ressources', 'FrontController@resources');
    Route::post('ressources', 'FrontController@setResources');

    Route::get('la-jungle', 'FrontController@map');
    Route::post('la-jungle/{base}', 'FrontController@loot');

    Route::get('construction', 'FrontController@builder');
    Route::post('construction/{builder}', 'FrontController@built');
});
