<?php

Route::resource('categories', 'CategoryController');
Route::resource('products', 'ProductController');

Route::group(['prefix' => 'auth'], function () {
    Route::post('register', 'Auth\RegisterController@action');
});
