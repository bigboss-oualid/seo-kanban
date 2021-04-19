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

use System\Application;

if (!function_exists('pre')) {
    /**
     * Visualize the given variable in browser and exit the application
     *
     * @param mixed   $var default exit the application or send 0 to continue
     * @param mixed $stop
     *
     * @return void
     */
    function pre($var, $stop = true): void
    {
        var_dump($var);

        if ($stop){
            die();
        }
    }
}

if(!function_exists('array_get')) {
    /**
     * Get the value from the given array for the given key if found otherwise get the default value
     *
     * @param  array        $array
     * @param  string|int   $key
     * @param  mixed        $default
     *
     * @return mixed
     */
    function array_get(array $array, $key, $default = null)
    {
        return isset($array[$key]) ? $array[$key] : $default;
    }
}

if(!function_exists('_escape')) {
    /**
     * Escape the given value
     *
     * @param  string | null  $value
     *
     * @return string
     */
    function _escape(string $value = null): string
    {
        return htmlspecialchars($value);
    }
}

if(!function_exists('urlHtml')) {
    /**
     * Generate full path for the given path
     *
     * @param  string  $path
     *
     * @return string
     */
    function urlHtml(string $path): string
    {
        $app = Application::getInstance();

        return $app->url->link($path);
    }
}

if(!function_exists('assets')) {
    /**
     * Generate full path for the given path in public directory
     *
     * @param  string  $path
     *
     * @return string
     */
    function assets(string $path): string
    {
        return urlHtml($path);
    }
}

if (! function_exists('seo')) {
    /**
     * Remove any unwanted characters from the given string
     * and replace it with -
     *
     * @param string $string
     *
     * @return string
     */
    function seo(string $string): string
    {
        // remove any white spaces from the beginning & the end of the given string
        $string = trim($string);

        // replace any non alphabet or numeric characters and dashes with white space
        $string = preg_replace('#[^\w]#', ' ' , $string);

        // replace any multi white spaces with just one white space
        $string = preg_replace('#[\s]+#', ' ', $string);

        $string = str_replace(' ', '-', $string);

        // make all letters in small case letters & trim any dashes
        return trim(strtolower($string), '-');
    }
}

