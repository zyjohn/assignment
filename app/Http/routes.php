<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */

Route::get('/', function () {
    return view('welcome');
});

Route::get('/product/list', 'View\ProductController@toProduct');
Route::get('/product/{product_id}', 'View\ProductController@toPdtContent');
Route::get('/cart', 'View\CartController@toCart');

Route::group(['prefix' => 'service'], function () {
    Route::post('upload/{type}', 'Service\UploadController@uploadFile');
    Route::get('cart/add/{option_id}', 'Service\CartController@addCart');
    Route::get('cart/less/{id}', 'Service\CartController@lessCart');
    Route::post('cart/pay', 'Service\CartController@payCart');
    Route::get('pay/result', 'Service\PayController@aliResult');
});

Route::group(['prefix' => 'admin'], function () {
    Route::group(['prefix' => 'service'], function () {
        Route::post('product/add', 'Admin\ProductController@productAdd');
        Route::post('option/add', 'Admin\OptionController@optionAdd');
        Route::post('product/delete', 'Admin\ProductController@productDel');
        Route::post('option/delete', 'Admin\OptionController@optionDel');
        Route::post('product/replace', 'Admin\ProductController@productReplace');
    });
    Route::get('product', 'Admin\ProductController@toProduct');
    Route::get('product_add', 'Admin\ProductController@toProductAdd');
    Route::get('product_edit', 'Admin\ProductController@toProductEdit');
});
