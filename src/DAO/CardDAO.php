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

use App\Model\Card;
use App\Model\Item;
use System\DAO;

class CardDAO extends DAO
{
    /**
     * Get All item's card
     *
     * @param  int $id
     *
     * @return array|null
     */
    public function getCardWithItems(int $cardId):?Card
    {
        // Select all columns board
        $card = new Card($this->where('id = ?', $cardId)->fetch($this->table));
        $items = $this->where('card_id = ?', $cardId)->fetchAll('card_item');



        foreach ($items as $item) {
            $item = new Item($item);
            $card->addItem($item);
        }

        return $card;
    }
    /**
     * Create new board
     *
     * @param int $boardId
     * @param int $columnId
     *
     * @return array
     */
    public function create(): array
    {
        $data['title'] = ucfirst($this->request->post('title'));
        $data['board_id'] = $this->request->post('board_id');
        $data['column_id'] = $this->request->post('list_id');

        $result = $this->data('title',  $data['title'])
            ->data('board_id', $data['board_id'])
            ->data('column_id', $data['column_id'])
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
    public function updateTitle(int $id): array
    {
        $title = ucfirst($this->request->post('title'));
        $data['title'] = $title;
        $this->data('title', $title);

        $result = $this->where('id=?', $id)
            ->update($this->table);

        return ['fields' => $data, 'result' => $result];
    }

    /**
     * Update board by its id
     *
     * @param int $id
     *
     * @return array
     */
    public function updateDescription(int $id): array
    {
        $description = ucfirst($this->request->post('description'));
        $data['description'] = $description;
        $this->data('description', $description);

        $result = $this->where('id=?', $id)
            ->update($this->table);

        return ['fields' => $data, 'result' => $result];
    }
}