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

use App\Model\User;
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
        $this->backendLayout->setTitle('Board list');
        $user = $this->user;

        if ($user->getUserRoleId() === User::ROLE_ADMIN) {
            $boards = $this->load->dao('Board')->all();
        } elseif($user->getUserRoleId() === User::ROLE_SUPERUSER){
            $boards = $this->load->dao('Board')->getBoardsForUser($user->getId());
        } else {
            $this->url->redirectTo('/403');
        }

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
    public function show(string $boardName, int $boardId)
    {
        $this->checkBoardAccess($boardId);

        $this->backendLayout->setTitle('Board: '. $boardName);
        $this->html->setTitle($boardName);
        $columns = $this->load->dao('ColumnBoard')->getAllColumnsBoardWithCard($boardId);
        $data['columns'] = $columns;
        $data['boardName'] = $boardName;
        $data['boardId'] = $boardId;

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
    public function edit(int $boardId): string
    {
        $this->checkBoardAccess($boardId);

        if ($this->isValid()) {
            return $this->json($this->load->dao('Board')->update($boardId));
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
    public function delete(int $boardId): string
    {
        $this->checkBoardAccess($boardId);

        $boards = $this->load->dao('Board');

        if($boards->exists($boardId)) {
            $boards->delete($boardId);
            return $this->json(['success' => 'Deleted']);
        }

        return $this->json(['errors' => 'The board with ' . $boards->get($boardId).' doesn\'t exists']);
    }

    /**
     * Validate the form
     *
     * @return boolean
     */
    private function isValid(int $id = null): bool
    {
        $this->validator->required('name', 'The name is required')
            ->minLen('name', 3)
            ->maxLen('name', 30);

        return $this->validator->passes();
    }

    /**
     * @param int $boardId
     */
    private function checkBoardAccess(int $boardId): void
    {
        $board = $this->load->dao('Board')->get($boardId);

        if (!$board) {
            $this->url->redirectTo('/404');
        }

        if($this->user->getUserRoleId() === User::ROLE_ADMIN){
            return;
        }

        if ($board->getUserId() !== $this->user->getId()) {
            $this->url->redirectTo('/403');
        }
    }
}