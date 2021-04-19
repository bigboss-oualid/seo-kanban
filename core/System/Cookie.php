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

class Cookie
{
    /**
     * Application Object
     *
     * @var Application
     */
    private Application $app;

    /**
     * Cookies Path
     *
     * @var string
     */
    private string $path = '/';

    /**
     * Constructor
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;

        /**
         * Get the path through the variable SCRIPT_NAME from $_SERVER,
         * Remove the file 'index.php' from path to get only the directory of the script name
         */
        $this->path = dirname($this->app->request->server('SCRIPT_NAME')) ?: '/';
    }

    /**
     * Set new value to cookie
     *
     * @param string $key
     * @param mixed  $value
     * @param int    $hours As defaults 3 Month
     *
     * @return void
     */
    public function set(string $key, $value, int $hours = 2160): void
    {
        //Remove the key from cookies if $hours = -1
        $expireTime = $hours == -1 ? -1 : time() + $hours * 3600;

        //change the sixth parameter to true if SSL will be used
        setcookie($key, $value, $expireTime, $this->path, '', false, true);
    }

    /**
     *  Get value from Cookies Cookie by the given key
     *
     * @param  string     $key
     * @param  mixed|null $default
     *
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return array_get($_COOKIE, $key, $default);
    }

    /**
     * Determine if the given key exists in Cookie

     * @param  string  $key
     *
     * @return boolean
     */
    public function has(string $key): bool
    {
        return array_key_exists($key, $_COOKIE);
    }

    /**
     * Remove the given key from cookies
     *
     * @param  string $key
     *
     * @return void
     */
    public function remove(string $key): void
    {
        $this->set($key, null, -1);

        unset($_COOKIE[$key]);
    }

    /**
     * Get all Cookies data
     *
     * @return array
     */
    public function all(): array
    {
        return $_COOKIE;
    }

    /**
     * Remove All Cookies
     *
     * @return void
     */
    public function destroy(): void
    {
        foreach (array_keys($this->all()) as $key) {
            $this->remove($key);
        }

        unset($_COOKIE);
    }
}

