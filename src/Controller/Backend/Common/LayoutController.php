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

namespace App\Controller\Backend\Common;

use System\Controller;
use System\View\ViewInterface;

class LayoutController extends Controller
{
     /**
     * Disabled Sections container
     *
     * @var array
     */
    private $disabledSections = [];

    /**
    * Render the layout with the given view Object
    *
    * @param ViewInterface $view
    */
    public function render(ViewInterface $view): ViewInterface
    {
        $data['content'] = $view;

        $sections = ['header', 'footer'];

        foreach ($sections as $section) {
            $data[$section] = in_array($section, $this->disabledSections) ? '' : $this->load->controller('Backend/Common/' . ucfirst($section))->index();
        }
        return $this->view->render('Backend/common/layout', $data);
    }

    /**
    * Disable content from layout page
    *
    * @param string $section
    * 
    * @return self
    */
    public function disable(string $section): self
    {
        $this->disabledSections[] = $section;

        return $this;
    }

     /**
     * Set the title for the blog page
     *
     * @param string $title
     * 
     * @return void
     */
    public function setTitle(string $title): void
    {
        $this->html->setTitle($title);
    }
}