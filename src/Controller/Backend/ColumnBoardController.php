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

class ColumnBoardController extends Controller
{
    /**
     * add new column
     *
     * @return string
     */
    public function add(): string
    {
        if ($this->isValid()) {
            return $this->json($this->load->dao('ColumnBoard')->create());
        }

        return $this->json(['errors' => $this->validator->detachMessages()]);
    }

    /**
     * update column
     *
     * @return int
     */
    public function edit(int $id): string
    {
        if ($this->isValid()) {
            return $this->json($this->load->dao('ColumnBoard')->update($id));
        }

        return $this->json(['errors' => $this->validator->detachMessages()]);
    }

    /**
     * Delete column
     *
     * @param int $boardid
     * @param int $id
     *
     * @return string
     */
    public function delete(int $id): string
    {
        $columns = $this->load->dao('ColumnBoard');

        if($columns->exists($id)) {
            $columns->delete($id);
            return $this->json(['success' => 'Deleted']);
        }

        return $this->json(['errors' => 'The Column doesn\'t exists']);
    }

    /**
     * Validate the form
     *
     * @return boolean
     */
    private function isValid(int $id = null): bool
    {
        $this->validator->required('title')
            ->minLen('title', 3)
            ->maxLen('title', 30);

        return $this->validator->passes();
    }
}