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
        ['url' => '/','controller' => 'Backend/Home', 'method' => 'GET' ],
        ['url' => '/boards','controller' => 'Backend/Board', 'method' => 'GET' ],
        ['url' => '/board/:text/:id','controller' => 'Backend/Board@show', 'method' => 'GET' ],
        ['url' => '/board/add', 'controller' => 'Backend/Board@add', 'method' => 'POST' ],
        ['url' => '/board/edit/:id', 'controller' => 'Backend/Board@edit', 'method' => 'POST' ],
        ['url' => '/board/delete/:id', 'controller' => 'Backend/Board@delete', 'method' => 'POST' ],
    ];