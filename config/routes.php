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

return
    [
        // Home route
        ['url' => '/', 'controller' => 'Frontend/Home', 'method' => 'GET'],

        // Register user routes
        ['url' => '/register', 'controller' => 'Frontend/Register', 'method' => 'GET'],
        ['url' => '/register/submit', 'controller' => 'Frontend/Register@submit', 'method' => 'POST' ],

        // Login/logout routes
        ['url' => '/login', 'controller' => 'Frontend/Login', 'method' => 'GET' ],
        ['url' => '/login/submit', 'controller' => 'Frontend/Login@submit', 'method' => 'POST' ],
        ['url' => '/logout', 'controller' => 'Backend/Logout', 'method' => 'GET' ],

        // Boards Routes
        ['url' => '/boards', 'controller' => 'Backend/Board', 'method' => 'GET'],
        ['url' => '/board/:text/:id', 'controller' => 'Backend/Board@show', 'method' => 'GET'],
        ['url' => '/board/add', 'controller' => 'Backend/Board@add', 'method' => 'POST'],
        ['url' => '/board/edit/:id', 'controller' => 'Backend/Board@edit', 'method' => 'POST'],
        ['url' => '/board/delete/:id', 'controller' => 'Backend/Board@delete', 'method' => 'POST'],

        // Columns board routes
        ['url' => '/column/add', 'controller' => 'Backend/ColumnBoard@add', 'method' => 'POST'],
        ['url' => '/column/edit/:id', 'controller' => 'Backend/ColumnBoard@edit', 'method' => 'POST'],
        ['url' => '/column/delete/:id', 'controller' => 'Backend/ColumnBoard@delete', 'method' => 'POST'],

        // Cards column routes
        ['url' => '/card/:id', 'controller' => 'Backend/Card', 'method' => 'GET'],
        ['url' => '/card/add', 'controller' => 'Backend/Card@addCard', 'method' => 'POST'],
        ['url' => '/card/title/edit/:id', 'controller' => 'Backend/Card@editTitleCard', 'method' => 'POST'],
        ['url' => '/card/description/edit/:id', 'controller' => 'Backend/Card@editDescriptionCard', 'method' => 'POST'],
        ['url' => '/card/delete/:id', 'controller' => 'Backend/Card@deleteCard', 'method' => 'POST'],

        // Items card routes (Checklist)
        ['url' => '/item/add', 'controller' => 'Backend/Card@addItem', 'method' => 'POST'],
        ['url' => '/item/edit/:id', 'controller' => 'Backend/Card@editItem', 'method' => 'POST'],
        ['url' => '/item/delete/:id', 'controller' => 'Backend/Card@deleteItem', 'method' => 'POST'],

        // Not Found route
        ['url' => '/404', 'controller' => 'NotFound', 'method' => 'GET' ],
        ['url' => '/403', 'controller' => 'NotFound@forbidden', 'method' => 'GET' ],
    ];