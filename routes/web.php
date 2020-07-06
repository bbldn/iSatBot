<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'MainController@indexAction');
Route::post('/telegram/webook', 'TelegramController@webHookHandlerAction');

Route::get('/order/new', 'TelegramController@newOrderNotifyAction');
Route::post('/order/new', 'TelegramController@newOrderNotifyAction');
