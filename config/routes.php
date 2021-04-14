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

return [
        ['url' => '/', 'controller' => 'Backend/Home', 'method' => 'GET'],

        ['url' => '/boards', 'controller' => 'Backend/Board', 'method' => 'GET'],
        ['url' => '/boards/:text/:id', 'controller' => 'Backend/Board@show', 'method' => 'GET'],
        ['url' => '/boards/add', 'controller' => 'Backend/Board@add', 'method' => 'POST'],
        ['url' => '/boards/edit/:id', 'controller' => 'Backend/Board@edit', 'method' => 'POST'],
        ['url' => '/boards/delete/:id', 'controller' => 'Backend/Board@delete', 'method' => 'POST'],

        //register
        ['url' => '/register', 'controller' => 'Backend/Register', 'method' => 'GET'],
        ['url' => '/register/submit', 'controller' => 'Backend/Register@submit', 'method' => 'POST' ],

        ['url' => '/login', 'controller' => 'Backend/Login', 'method' => 'GET' ],
        ['url' => '/login/submit', 'controller' => 'Backend/Login@submit', 'method' => 'POST' ],
        ['url' => '/logout', 'controller' => 'Backend/logout', 'method' => 'GET' ],


        ['url' => '/404', 'controller' => 'NotFound', 'method' => 'GET' ],

    ];