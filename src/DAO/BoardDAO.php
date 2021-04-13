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

class BoardDAO extends DAO
{
    /**
     * Create new board
     *
     * @return array
     */
    public function create(): array
    {
        $data['name'] = ucfirst($this->request->post('name'));
        $data['user_id'] =  $this->request->post('user_id');
        $data['slug'] =  seo( $data['name']);

        $result = $this->data('name',  $data['name'])
            ->data('user_id', $data['user_id'])
            ->insert($this->table);
        return ['fields' => $data, 'result' => $result, 'lastInsertID' => $this->lastId()];
    }

    /**
     * Update board by its id
     *
     * @param int $id
     *
     * @return array
     */
    public function update(int $id): array
    {
        $name = ucfirst($this->request->post('name'));

        $result = $this->data('name', $name)
            ->where('id=?', $id)
            ->update($this->table);

        return ['fields' => $name, 'result' => $result];
    }
}