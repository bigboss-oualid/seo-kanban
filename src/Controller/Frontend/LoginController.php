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

class LoginController extends Controller
{
    /**
     * Display Login Form
     *
     * @return mixed
     */
    public function index()
    {
        $this->frontendLayout->setTitle('Sign in');

        $loginDAO = $this->load->dao('Login');

        if ($loginDAO->isLogged()) {
            return $this->url->redirectTo('/');
        }

        $view = $this->view->render('Frontend/account/login');

        return $this->frontendLayout->render($view);
    }

    /**
     * Submit Login form
     *
     * @return mixed
     */
    public function submit():string
    {
        if ($this->isValid()) {
            $loginDao = $this->load->dao('Login');

            $loggedInUser = $loginDao->user();
            if($this->request->post('rememberMe')=== 'true'){
                // Save login data in COOKIE
                $this->cookie->set('login', $loggedInUser->getCode());
            } else {
                // Save login data in SESSION
                $this->session->set('login', $loggedInUser->getCode());
            }

            return $this->json(['result' => "Welcome {$loggedInUser->getUsername()}", 'redirectTo' => urlHtml('/')]);
        }

        return $this->json(['errors' => $this->validator->getMessages()]);
    }

    /**
     * Validate Login Form
     *
     * @return bool
     */
    private function isValid(): bool
    {
        $this->validator->required('username', 'Please insert your username');
        $this->validator->required('password', 'Please insert your password');
        $username = $this->request->post('username');
        $password = $this->request->post('password');

        //username's input is correct & insert, password is insert
        if($this->validator->passes()){
            $loginModel = $this->load->dao('Login');
            $loggedInUser = $loginModel->isValidLogin($username, $password);

            //Password or Email or both are not correct
            if (! $loggedInUser) {
                $this->validator->message('Login data is not valid');
            }
        }

        return $this->validator->passes();
    }
}