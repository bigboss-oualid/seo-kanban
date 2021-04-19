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

namespace App\Controller\Frontend\Common;

use System\Controller;

class FooterController extends Controller
{
    /**
     * return footer for index page
     *
     *  @return string
     */
    public function index(): string
    {
        $data['user'] = $this->load->dao('Login')->user();
        return $this->view->render('Frontend/common/footer', $data);
    }
}