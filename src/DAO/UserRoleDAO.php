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

class UserRoleDAO extends DAO
{
    /**
     * Database Table name
     *
     * @var string
     */
    protected ?string $table = 'user_role';

    /**
     * Get users role
     *
     * @param int $id
     *
     * @return mixed
     */
    public function get(int $id)
    {
        $userRole = parent::get($id);

        if ($userRole) {
            $pages = $this->select('page')->where('user_role_id = ?', $userRole['id'])->fetchAll('user_role_permission');

            $userRole['pages'] = [];

            if ($pages) {
                foreach ($pages as $page) {
                    $userRole['pages'][] = $page['page'];
                }
            }
        }

        return $userRole;
    }
}