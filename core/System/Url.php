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

namespace System;

class Url
{
    /**
     * Application Object
     *
     * @var Application
     */
    protected Application $app;

    /**
     * Constructor
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Generate full link for the given path
     *
     * @param string  $path
     *
     * @return string
     */
    public function link(string $path): string
    {
        return $this->app->request->baseUrl() . trim($path, '/');
    }

    /**
     * Redirect to the given Path
     *
     * @param string  $path
     *
     * @return void
     */
    public function redirectTo(string $path): void
    {
        header('location:' . $this->link($path));
        exit;
    }
} 