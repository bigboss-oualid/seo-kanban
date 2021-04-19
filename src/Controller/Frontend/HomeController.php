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

namespace App\Controller\Frontend;

use System\Controller;

class HomeController extends Controller
{
     /**
     * Display Home Page
     *
     * @return mixed
     */
    public function index()
    {
        $this->frontendLayout->setTitle('Homepage');
        $data['titlePage'] = 'Homepage Kanban Application';

        $view = $this->view->render('frontend/home', $data);

        return $this->frontendLayout->render($view)->getOutput();
    }
}