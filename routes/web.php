<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'MainController@indexAction');
Route::post('/telegram/webook', 'TelegramController@webHookHandlerAction');
