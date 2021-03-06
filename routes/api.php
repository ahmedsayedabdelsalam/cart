<?php

Route::resource('categories', 'CategoryController');
Route::resource('products', 'ProductController');

Route::group(['prefix' => 'auth'], function () {
    Route::post('register', 'Auth\RegisterController@action');
    Route::post('login', 'Auth\LoginController@action');
    Route::get('me', 'Auth\MeController@action');
});

Route::resource('cart', 'CartController', [
    'parameters' => [
        'cart' => 'productVariation'
    ]
]);
