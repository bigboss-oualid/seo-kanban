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

use App\Model\User;
use System\DAO;

class LoginDAO extends DAO
{
    /**
     * Database table name
     *
     * @var ?string
     */
    protected ?string $table = 'user';

    /**
     * Logged in User
     *
     * @var ?User
     */
    private ?User $user = null;

    /**
     * Determine if the given login data is valid
     *
     * @param string $username
     * @param string $password
     *
     * @return boolean
     */
    public function isValidLogin(string $username, string $password): bool
    {
        $loggedUser = $this->select('user.*','ur.name AS `user_group`')
            ->from($this->table)
            ->join('LEFT JOIN user_role ur On user.user_role_id=ur.id')
            ->where('username=?', $username)->fetch($this->table);


        if (! $loggedUser) {return false;}

        $this->user = new User($loggedUser);

        return password_verify($password, $this->user->getPassword());
    }

    /**
     * Get Logged in User data
     *
     * @return ?User
     */
    public function user(): ?User
    {
        return $this->user;
    }

    /**
     * Determine whether the user is logged in
     *
     * @return boolean
     */
    public function isLogged(): bool
    {
        if ($this->cookie->has('login')) {
            $code = $this->cookie->get('login');
        } elseif($this->session->has('login')) {
            $code = $this->session->get('login');
        } else {
            $code = '';
        }

        $loggedUser = $this->select('user.*','ur.name AS `user_role`')
            ->from($this->table)
            ->join('LEFT JOIN user_role ur On user.user_role_id=ur.id')
            ->where('code=?' ,$code)->fetch($this->table);
        if (!$loggedUser) {
            return false;
        }

        $this->user = new User($loggedUser);

        return true;
    }
}