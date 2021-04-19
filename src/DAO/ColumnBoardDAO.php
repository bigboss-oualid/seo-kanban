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

class ColumnBoardDAO extends DAO
{
    /**
     * Database table name
     *
     * @var ?string
     */
    protected ?string $table = 'column_board';

    /**
     * Get All Column's board from its ID
     *
     * @param  int $id
     *
     * @return array|null
     */
    public function getAllColumnsBoardWithCard(int $id):?array
    {
        /*$results = $this->select('ca.*', 'co.*')
            ->from('column_board co')
            ->join('LEFT JOIN card ca ON co.id=ca.board_id')
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
        $data['title'] = ucfirst($this->request->post('title'));
        $data['board_id'] =  $this->request->post('board_id');

        $result = $this->data('title',  $data['title'])
            ->data('board_id', $data['board_id'])
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
        $title = ucfirst($this->request->post('title'));

        $result = $this->data('title', $title)
            ->where('id=?', $id)
            ->update($this->table);

        return ['fields' => $title, 'result' => $result];
    }
}