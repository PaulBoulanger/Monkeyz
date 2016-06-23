<?php


Route::auth();

Route::group(['middleware' => 'auth'], function() {
    Route::get('/', 'FrontController@home');
    Route::get('maison-des-primates', 'FrontController@units');
    Route::get('singeries', 'FrontController@recruits');
    Route::post('singeries', 'FrontController@addRecruits');
});
