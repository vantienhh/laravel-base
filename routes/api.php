<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/contacts', 'ContactController@index');
$router->get('/contacts/{contactId}/subscribers', 'ContactController@listSubscriber');

$router->post('/subscribers', 'SubscriberController@store');
