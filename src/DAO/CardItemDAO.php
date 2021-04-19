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
use App\Model\ColumnBoard;
use System\DAO;
use System\Database;

class CardItemDAO extends DAO
{
    /**
     * Database table name
     *
     * @var ?string
     */
    protected ?string $table = 'card_item';
    /**
     * Get All Item's Card from its ID
     *
     * @param  int $id
     *
     * @return array|null
     */
    public function getAllCardsItem(int $id):?array
    {
        /*$results = $this->select('ca.*', 'co.*')
            ->from('column_board co')
            ->join('LEFT JOIN card ca ON co.id=ca.board_id')
            ->where('co.board_id=?', $id)
            ->fetchAll();*/

        // Select all columns board
        $columns = $this->where('board_id = ?', $id)->fetchAll($this->table);
        $cards = $this->where('board_id > ?', 0)->fetchAll('card');

        $cardsContainer = [];
        foreach ($cards as $card) {
            $card = new Card($card);
            $cardsContainer[] = $card;
        }

        $columnsContainer = [];
        foreach ($columns as $column) {
            $column = new ColumnBoard($column);
            foreach ($cardsContainer as $card){
                if($card->getColumnId() == $column->getId()){
                    $column->addCard($card);
                }
            }
            $columnsContainer[] = $column;
        }

        return $columnsContainer;
    }
    /**
     * Create new board
     *
     * @return array
     */
    public function create(): array
    {
        $data['text'] = ucfirst($this->request->post('text'));
        $data['card_id'] =  $this->request->post('card_id');
        $data['board_id'] =  $this->request->post('board_id');

        $result = $this->data('text',  $data['text'])
            ->data('card_id', $data['card_id'])
            ->data('board_id', $data['board_id'])
            ->data('is_completed', 0)
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
    public function update(int $itemId): array
    {
        $text = ucfirst($this->request->post('text'));
        $isCompleted = ucfirst($this->request->post('is_completed'));

        $data = [];

        if($text){
            $data['text'] = $text;
            $this->data('text', $text);
        }

        if($isCompleted){
            $data['text'] = $isCompleted;
            $this->data('is_completed', $isCompleted);
        }

        $result = $this->where('id=?', $itemId)
            ->update($this->table);

        return ['fields' => $data, 'result' => $result];
    }
}