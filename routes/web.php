<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/front/order/add', 'MainController@orderAction');
$router->get('/front/customer/add', 'MainController@customerAction');