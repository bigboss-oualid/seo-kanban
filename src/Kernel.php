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

// Share user if is logged
$app->share('user', function ($app) {
    $loginDao = $app->load->dao('Login');
    $loginDao->isLogged();

    return $loginDao->user();
});

$user = $app->user;

// if user logged make backend free to be used
if(isset($user)){
    // TODO: make road access more stringent
    /*if (strpos($app->request->url(), '/boards') === 0) {
        //Call middlewares
        $app->route->callFirst(function ($app) {
            $app->load->action('backend/Access', 'index');
        });
    }*/
    $app->share('backendLayout', function ($app) {
        return $app->load->controller('backend/Common/Layout');
    });
}

$app->share('frontendLayout', function ($app) {
    return $app->load->controller('frontend/Common/Layout');
});


$routes = $parameter = $app->file->call('config/routes.php');

// Add Routes
foreach($routes as $route){
    $app->route->add($route['url'], $route['controller'], $route['method']);
}
