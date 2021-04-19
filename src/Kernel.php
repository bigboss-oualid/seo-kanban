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

use System\Application;

$app =  Application::getInstance();

$routes = $parameter = $app->file->call('config/routes.php');

// Share user if is logged
$app->share('user', function ($app) {
    $loginDao = $app->load->dao('Login');
    $loginDao->isLogged();

    return $loginDao->user();
});

$user = $app->user;

// if user is logged in make backend free to be used
if(isset($user)){
    // TODO: make road access more stringent
    /*if (strpos($app->request->url(), '/boards') === 0) {
        //Call middlewares
        $app->route->callFirst(function ($app) {
            $app->load->action('backend/Access', 'index');
        });
    }*/
    $app->share('backendLayout', function ($app) {
        return $app->load->controller('Backend/Common/Layout');
    });
    // Add Backend Routes
    foreach($routes['backend'] as $route){
        $app->route->add($route['url'], $route['controller'], $route['method']);
    }
}

$app->share('frontendLayout', function ($app) {
    return $app->load->controller('Frontend/Common/Layout');
});


// Add Frontend Routes
foreach($routes['frontend'] as $route){
    $app->route->add($route['url'], $route['controller'], $route['method']);
}
