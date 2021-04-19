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
use System\UserInterface;

class Card extends Model
{
    private int $id;
    private string $title;
    private ?string $description = '';
    private int $boardId;
    private int $columnId;
    private array $items = [];

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
     * @return self
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param string $title
     *
     * @return User
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string|null $description
     *
     * @return self
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return ?string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getBoardId(): string
    {
        return $this->boardId;
    }

    /**
     * @param int $boardId
     *
     * @return self
     */
    public function setBoardId(int $boardId): self
    {
        $this->boardId = $boardId;

        return $this;
    }

    /**
     * @param int $columnId
     *
     * @return self
     */
    public function setColumnId(int $columnId): self
    {
        $this->columnId = $columnId;

        return $this;
    }

    /**
     * @return int
     */
    public function getColumnId(): string
    {
        return $this->columnId;
    }

    /**
     * @return self
     */
    public function addItem(Item $item): self
    {
        if (!isset( $this->items[$item->getId()])) {
            $this->items[$item->getId()] = $item;
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @return self
     */
    public function removeItem(Item $item): self
    {
        if(array_key_exists (  $item->getId()() , $this->items )){
            unset($this->items[$item->getId()()]);
        }

        return $this;
    }

}