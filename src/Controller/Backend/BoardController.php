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

class BoardController extends Controller
{
    /**
     * Display single Page
     *
     * @return mixed
     */
    public function index()
    {
        $this->backendLayout->setTitle('Board list ');
        $boards = $this->load->dao('Board')->all();

        $data['boards'] = $boards;
        $view = $this->view->render('backend/boards/list_boards', $data);

        return $this->backendLayout->render($view);
    }

    /**
     * Display single page Page
     *
     * @param string $name
     * @param int    $id
     *
     * @return mixed
     */
    public function show(string $name, int $id)
    {
        $this->backendLayout->setTitle('Board: '. $name);

        $board = $this->load->dao('Board')->get($id);
        if (!$board) {return $this->url->redirectTo('/404');}
        $this->html->setTitle($board->getName());
        $data['board'] = $board;

        $view = $this->view->render('backend/boards/single_board', $data);

        return $this->backendLayout->render($view);
    }

    /**
     * add board From
     *
     * @return string
     */
    public function add(): string
    {
        if ($this->isValid()) {
            return $this->json($this->load->dao('Board')->create());
        }

        return $this->json(['errors' => $this->validator->detachMessages()]);
    }

    /**
     * update board From
     *
     * @return string
     */
    public function edit(int $id): string
    {
        if ($this->isValid()) {
            return $this->json($this->load->dao('Board')->update($id));
        }

        return $this->json(['errors' => $this->validator->detachMessages()]);
    }

    /**
     * Delete Board
     *
     * @param int $id
     *
     * @return string
     */
    public function delete(int $id): string
    {
        $boards = $this->load->dao('Board');

        if($boards->exists($id)) {
            $boards->delete($id);
            return $this->json(['success' => 'Deleted']);
        }

        return $this->json(['errors' => 'The board with ' . $boards->get($id).' doesn\'t exists']);
    }

    /**
     * Validate the form
     *
     * @return boolean
     */
    private function isValid(int $id = null): bool
    {
        $this->validator->required('name', 'The name is required');
        $this->validator->minLen('name', 3);
        $this->validator->maxLen('name', 30);

        return $this->validator->passes();
    }
}