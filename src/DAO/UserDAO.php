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

namespace App\DAO;


use System\DAO;

class UserDAO extends DAO
{

    /**
     * register new user record then send success message back
     *
     * @return array
     */
    public function create(): array
    {
        $userRoleId = ucfirst($this->request->post('user_role_id'));
        $username   = ucfirst($this->request->post('username'));
        $password   = ucfirst($this->request->post('password'));

        if (!$userRoleId) {
            $userRoleId = '3';
        }

        $result = $this->data('user_role_id', $userRoleId)
            ->data('username', $username)
            ->data('password', password_hash($password, PASSWORD_DEFAULT))
            ->data('code', sha1(time() . mt_rand()))
            ->insert('user');

        return ['fields' => ['username'=>$username], 'result' => $result, 'redirectTo' => urlHtml('/login')];
    }
}