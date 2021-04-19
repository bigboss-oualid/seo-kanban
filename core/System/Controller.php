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

abstract class Controller
{
    /**
     * Application Object
     *
     * @var Application
     */
    protected Application $app;

    /**
     * Errors container
     *
     * @var array
     */
    protected $errors = [];

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
     * Encode the given value to Json
     *
     * @param mixed $data
     *
     * @return string
     */
    public function json($data): string
    {
        return json_encode($data);
    }

    /**
     * Call shared Application Objects dynamically
     *
     * @param string  $key
     *
     * @return mixed
     */
    public function __get(string $key)
    {
        return $this->app->get($key);
    }
} 