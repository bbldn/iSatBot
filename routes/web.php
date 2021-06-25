<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/order/new', 'TelegramController@newOrderNotifyAction');
$router->post('/order/new', 'TelegramController@newOrderNotifyAction');

$router->post('/telegram/webook', 'TelegramController@webHookHandlerAction');