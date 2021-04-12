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

namespace System\View;

use System\Application;

class ViewFactory
{
    /**
     * Application Object
     *
     * @var Application
     */
    private $app;

    /**
     * Constructor
     *
     * @param Application $app
     */
    function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Render the given view path with the passed variables and generate
     * new View Object for it
     *
     * @param  string $viewPath
     * @param  array  $data Passed variable to view
     *
     * @return ViewInterface
     */
    public function render(string $viewPath, array $data = []): ViewInterface
    {
        return new View($this->app->file, $viewPath, $data);
    }
}