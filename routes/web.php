<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'MainController@indexAction');
Route::post('/telegram/webook', 'TelegramController@webHookHandlerAction');

Route::get('/order/new', 'MainController@indexAction');
Route::post('/order/new', 'MainController@indexAction');
