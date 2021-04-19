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

class CardController extends Controller
{
    /**
     * Display single Page
     *
     * @param int $boardId
     * @param int $cardId
     *
     * @return string
     */
    public function index(int $cardId):string
    {
        $this->backendLayout->setTitle('Card: '. $cardId);

        $card = $this->load->dao('Card')->getCardWithItems($cardId);
        //Disable sidebar
        $this->backendLayout->disable('header');
        $this->backendLayout->disable('footer');

        if (!$card) {return $this->url->redirectTo('/404');}
        $data['card'] = $card;

        $this->html->setTitle($card->getTitle());

        $view = $this->view->render('Backend/cards/single_card', $data);

        return $this->backendLayout->render($view);
    }

    /**
     * add new Card
     *
     * @return string
     */
    public function addCard(): string
    {
        if ($this->isCardValid()) {
            return $this->json($this->load->dao('Card')->create());
        }

        return $this->json(['errors' => $this->validator->detachMessages()]);
    }

    /**
     * Update Card title
     *
     * @return string
     */
    public function editTitleCard(int $id): string
    {
        if ($this->isCardValid()) {
            return $this->json($this->load->dao('Card')->updateTitle($id));
        }

        return $this->json(['errors' => $this->validator->detachMessages()]);
    }

    /**
     * Update Card title
     *
     * @return string
     */
    public function editDescriptionCard(int $id): string
    {
        return $this->json($this->load->dao('Card')->updateDescription($id));

    }

    /**
     * Delete column
     *
     * @param int $id
     *
     * @return string
     */
    public function deleteCard(int $id): string
    {
        $columns = $this->load->dao('Card');

        if($columns->exists($id)) {
            $columns->delete($id);
            return $this->json(['success' => 'Deleted']);
        }

        return $this->json(['errors' => 'The Card doesn\'t exists']);
    }

    /**
     * Validate the form
     *
     * @return boolean
     */
    private function isCardValid(int $id = null): bool
    {
        $this->validator->required('title')
            ->minLen('title', 3)
            ->maxLen('title', 30);

        return $this->validator->passes();
    }

    /**
     * add new Item
     *
     * @return string
     */
    public function addItem(): string
    {
        if ($this->isItemValid()) {
            return $this->json($this->load->dao('CardItem')->create());
        }

        return $this->json(['errors' => $this->validator->detachMessages()]);
    }

    /**
     * Update Item
     *
     * @return string
     */
    public function editItem(int $ItemId): string
    {
        if ($this->request->post('text') && !$this->isItemValid()) {
            return $this->json(['errors' => $this->validator->detachMessages()]);
        } else {
            return $this->json($this->load->dao('CardItem')->update($ItemId));
        }
    }

    /**
     * Delete Item
     *
     * @param int $id
     *
     * @return string
     */
    public function deleteItem(int $id): string
    {
        $columns = $this->load->dao('CardItem');

        if($columns->exists($id)) {
            $columns->delete($id);
            return $this->json(['success' => 'Deleted']);
        }

        return $this->json(['errors' => 'The Card doesn\'t exists']);
    }

    /**
     * Validate the form
     *
     * @return boolean
     */
    private function isItemValid(int $id = null): bool
    {
        $this->validator->maxLen('text', 30);

        return $this->validator->passes();
    }
}