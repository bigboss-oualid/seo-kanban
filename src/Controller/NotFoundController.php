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

namespace App\Controller;


use System\Controller;

class NotFoundController extends Controller
{
    public function index()
    {
        $data = [
            'errorTitle' => '404 Not Found',
            'description' => 'Sorry, an error occurred, the requested page could not be found !!',
        ];

        return $this->view->render('not-found', $data);
    }
    public function forbidden()
    {
        $data = [
            'errorTitle' => '403 Not Found',
            'description' => 'You don\'t have permission to access / on this page !!',
            'color' => 'style="color: whitesmoke;background-color:red;"'
        ];

        return $this->view->render('not-found', $data);
    }
}