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

namespace App\Model;


use System\Model;

class ColumnBoard extends Model
{
    private int $id;
    private string $title;
    private int $boardId;
    private array $cards = [];

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return  self
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return int
     */
    public function getBoardId(): int
    {
        return $this->boardId;
    }

    /**
     * @param int $boardId
     *
     * @return  self
     */
    public function setBoardId(int $boardId): self
    {
        $this->boardId = $boardId;
        return $this;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return  self
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return self
     */
    public function addCard(Card $card): self
    {
        if (!isset( $this->cards[$card->getId()])) {
            $this->cards[$card->getId()] = $card;
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getCards(): array
    {
        return $this->cards;
    }

    /**
     * @return self
     */
    public function removeCard(Card $card): self
    {
        if(array_key_exists (  $card->getId()() , $this->cards )){
            unset($this->cards[$card->getId()()]);
        }

        return $this;
    }
}