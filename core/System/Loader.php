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

class Loader
{
    /**
     * Application Object
     *
     * @var Application
     */
    private Application $app;

    /**
     * Controllers Container
     *
     * @var array
     */
    private $controllers = [];

    /**
     * Models Container
     *
     * @var array
     */
    private $daos = [];

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
     * Call the given controller with the given method
     * and pass the given arguments to the controller method
     *
     * @param string $controller
     * @param string $method
     * @param array  $arguments
     *
     * @return mixed
     */
    public function action(string $controller, string $method, array $arguments = [])
    {
        $object = $this->controller($controller);

        return call_user_func_array([$object, $method], $arguments);
    }

    /**
     * Call the given controller
     *
     * @param  string $controller name
     *
     * @return Controller
     */
    public function controller(string $controller): Controller
    {
        $controller = $this->getControllerPath($controller);

        if(! $this->hasController($controller)){
            $this->addController($controller);
        }

        return $this->getController($controller);
    }

    /**
     * Determine if  the given Class(controller) exists in the controllers container
     *
     * @param  string  $controller
     *
     * @return boolean
     */
    private function hasController(string $controller): bool
    {
        return array_key_exists($controller, $this->controllers);
    }

    /**
     * Create new Object for the given controller and store it in the controllers container
     *
     * @param string $controller
     *
     * @return void
     */
    private function addController(string $controller): void
    {
        $object = new $controller($this->app);

        $this->controllers[$controller] = $object;
    }

    /**
     * Get the given controller object
     *
     * @param  string $controller
     *
     * @return Controller
     */
    private function getController(string $controller): Controller
    {
        return $this->controllers[$controller];
    }

    /**
     * Get the full class name for the given Controller
     *
     * @param  string $controller
     *
     * @return string
     */
    private function getControllerPath(string $controller): string
    {
        $controller .= 'Controller';

        $controller  = 'App\\Controller\\' . $controller;

        return str_replace('/', '\\', $controller);
    }

    /**
     * Call the given dao
     *
     * @param string $dao
     *
     * @return DAO
     */
    public function dao(string $dao): DAO
    {
        $daoPath = $this->getDAOPath($dao);

        if(! $this->hasDAO($daoPath)){
            $this->addDAO($daoPath);
        }

        return $this->getDAO($daoPath);
    }

    /**
     * Determine if  the given class exists in the DAOs
     *  container
     *
     * @param  string $dao
     *
     * @return boolean
     */
    private function hasDAO(string $dao): bool
    {
        return array_key_exists($dao, $this->daos);
    }

    /**
     * Create new Object for the given class and store ot in daos
     * container
     *
     * @param string $dao
     *
     * @return void
     */
    private function addDAO(string $dao): void
    {
        $object = new $dao($this->app);

        //App\DAO\BoardDAO
        $this->daos[$dao] = $object;
    }

    /**
     * Get the given DAO object
     *
     * @param  string $dao
     *
     * @return null|DAO
     */
    private function getDAO(string $dao): ?DAO
    {
        return $this->daos[$dao];
    }

    /**
     * Get the full class name for the given dao
     *
     * @param  string $dao
     *
     * @return string
     */
    private function getDAOPath(string $dao): string
    {
        $dao .= 'DAO';

        $daoPath  = 'App\\DAO\\' . $dao;

        return str_replace('/', '\\', $daoPath);
    }
} 