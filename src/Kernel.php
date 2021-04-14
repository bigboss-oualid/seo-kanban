<?php
/*
 * Copyright (c) 2021. Boulatar Oualid - All Rights Reserved
 *  You may use, distribute and modify this code under the
 *  terms of the LGP license, which unfortunately won't be
 *  written for another century.
 *
 *  You should have received a copy of the LGP license with
 *  this file. If not, please write to:  oualid@boulatar.com, or visit : https://boulatar.com
 */

//White list Routes
use System\Application;

$app =  Application::getInstance();


$app->share('user', function ($app) {
    $loginDao = $app->load->dao('Login');

    $loginDao->isLogged();
    $user = $loginDao->user();

    return $user;
});

$app->share('backendLayout', function ($app) {
    return $app->load->controller('Backend/Common/Layout');
});

$routes = $parameter = $app->file->call('config/routes.php');

// Add Routes
foreach($routes as $route){
    $app->route->add($route['url'], $route['controller'], $route['method']);
}
