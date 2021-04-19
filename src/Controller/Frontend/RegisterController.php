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

class RegisterController extends Controller
{
    /**
     * Display single page Page
     *
     * @return mixed
     */
    public function index()
    {
        $this->frontendLayout->setTitle('Sign up');
        $loginDAO = $this->load->dao('Login');

        if (isset($loginDAO) && $loginDAO->isLogged()) {
            return $this->url->redirectTo('/');
        }

        $view = $this->view->render('frontend/account/register');

        return $this->frontendLayout->render($view);
    }

    /**
     * Submit for creating new user
     *
     * @return string
     */
    public function submit()
    {
        if ($this->isValid()) {
            // TODO Set the user_role_id manually: can be added in SETTINGS $this->request->setPost('user_role_id', 0);
            return $this->json($this->load->dao('User')->create());
        }

        return $this->json(['errors' => $this->validator->getMessages()]);
    }

    /**
     * Validate the form
     *
     * @param int $id
     *
     * @return bool
     */
    private function isValid()
    {
        $this->validator->required('username')->minLen('username', 3)->unique('username', ['user', 'username']);
        $this->validator->required('password')->password('password')->match('password', 'confirm_password');

        return $this->validator->passes();
    }
}