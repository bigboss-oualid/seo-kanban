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

use Closure;

class Application
{
    /**
     * Save Object or mixed data
     *
     * @var array
     */
    private $container = [];

    /**
     * Application Object
     *
     * @var Application|null
     */
    private static Application $instance;

    /**
     * Constructor
     *
     * @param File $file
     */
    private function __construct(File $file)
    {
        $this->share('file', $file);

        $this->loadHelpers();
    }

    /**
     * Get Application Instance
     *
     * @param File $file
     *
     * @return Application
     */
    public static function getInstance(File $file = null): ?Application
    {
        if (!isset(static::$instance)) {
            static::$instance = new static($file);
        }
        return static::$instance;
    }


    /**
     * run the Application leads to a session start
     *
     * @return void
     */
    public function run(): void
    {
        $this->session->start();

        $this->request->prepareUrl();

        $this->file->call('src/Kernel.php');

        [$controller, $method, $arguments] = $this->route->getProperRoute();

        if($this->route->hasCallsFirst()){
            $this->route->callFirstCalls();
        }

        $output = (string) $this->load->action($controller, $method, $arguments);

        $this->response->setOutput($output);

        $this->response->send();
    }

    /**
     * Load Helpers File
     *
     * @return void
     */
    private function loadHelpers(): void
    {
        $this->file->call('core/helpers.php');
    }

    /**
     * Get all core classes with its aliases
     *
     * @return array ['Alias' => '\\Path...\\file']
     */
    private function coreClasses(): array
    {
        return [
            'request'     => 'System\\Http\\Request',
            'response'	  => 'System\\Http\\Response',
            'session'     => 'System\\Session',
            'route'       => 'System\\Route',
            'load'        => 'System\\Loader',
            'cookie'      => 'System\\Cookie',
            'html'        => 'System\\Html',
            'view'        => 'System\\View\\ViewFactory',
            'db'          => 'System\\Database',
            'url'         => 'System\\Url',
            'validator'   => 'System\\Validation',
        ];
    }

    /**
     * Determine if the given key is an alias to core class
     *
     * @param  string  $alias
     *
     * @return bool
     */
    private function isCoreAlias(string $alias): bool
    {
        $coreClasses = $this->coreClasses();

        return isset($coreClasses[$alias]);
    }

    /**
     * Creat new object for the core class based on the given alias, and pass the Application to his constructor
     *
     * @param  string $alias
     *
     * @return mixed
     */
    private function createNewCoreObject(string $alias)
    {
        $coreClasses = $this->coreClasses();
        $object = $coreClasses[$alias];

        return new $object($this);
    }

    /**
     * Share the given key|value (files) through the Application
     *
     * @param  string $key
     * @param  mixed $value
     *
     * @return mixed
     */
    public function share(string $key, $value): void
    {
        if($value instanceof Closure) {
            $value = call_user_func($value, $this);
        }
        $this->container[$key] = $value;
    }

    /**
     * Determine if the given key is shared through Application means is it saved in the $container[$key] ?
     *
     * @param  string $key
     *
     * @return bool
     */
    public function isSharing(string $key): bool
    {
        return isset($this->container[$key]);
    }

    /**
     * Get the shared value of the property
     *
     * @param  string $key
     *
     * @return mixed
     */
    public function get(string $key)
    {
        if(! $this->isSharing($key)) {
            if ($this->isCoreAlias($key)) {
                $this->share($key, $this->createNewCoreObject($key));
            } elseif($key === 'user') {
                return null;
            } else {
                die('<strong>' . $key . '</strong> not found in application Container, look the coreClasses() function for more details');
            }
        }
        return $this->container[$key];
    }

    /**
     * Get shared value dynamically when the property doesn't exist in this file
     *
     * @param  string $key
     *
     * @return mixed
     */
    public function __get(string $key)
    {
        return $this->get($key);
    }
}