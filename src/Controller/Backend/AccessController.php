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


namespace App\Controller\Backend;


use System\Controller;

class AccessController extends Controller
{
    /**
     * Check User Permissions to access board pages
     *
     * @return mixed
     */
    public function index()
    {
        $loginDAO = $this->load->dao('Login');

        $ignoredPages = ['/login', '/login/submit','/logout'];

        $currentRoute = $this->route->getCurrentRouteUrl();

        //Not logged in & not requesting login page
        if (($isNotLogged =  !$loginDAO->isLogged()) && ! in_array($currentRoute , $ignoredPages)) {
            // Redirect him to login page
            return $this->url->redirectTo('/login');
        }
        // Not logged in & requesting login page
        // OR is logged in successfully &  requesting admin page
        if ($isNotLogged) {
            return false;
        }

        $user = $loginDAO->user();

        $userRoleDAO = $this->load->dao('userRole');

        $userRole = $userRoleDAO->get($user->getUserRoleId());
        // User try to access admin page or No permissions to access an admin page
        if ((! $userRole) || (! in_array($currentRoute, $userRole['pages'])) )  {
            //Redirected to 404 page
            //may create access-denied page
            return $this->url->redirectTo('/403');
        }
    }
}