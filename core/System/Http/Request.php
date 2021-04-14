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

namespace System\Http;

class Request
{
    /**
     * Url
     *
     * @var string|null
     */
    private ?string $url;

    /**
     * Base Url
     *
     * @var string|null
     */
    private ?string $baseUrl;

    /**
     * Prepare Url and save it in the property $baseUrl
     *
     * @return void
     */
    public function prepareUrl(): void
    {
        //pre($_SERVER); //Get information about the server
        $script = dirname($this->server('SCRIPT_NAME'));
        $requestUri = $this->server('REQUEST_URI');

        //Save the first part from link before '?', in the variable $requestUri
        if(strpos($requestUri, '?') !== false) {
            list($requestUri) = explode('?', $requestUri);
        }
        $this->url = rtrim( preg_replace('#^' . $script . '#', '', $requestUri), '/');
        //$this->url = "/". rtrim( preg_replace('#^' . $script . '#', '', $requestUri), '/');
        if (! $this->url) {
            $this->url = '/';
        }

        $script = rtrim($script, '/');

        $this->baseUrl = $this->server('REQUEST_SCHEME') . '://' . $this->server('HTTP_HOST') . $script . '/';
    }

    /**
     * Get only relative url (clean url)
     *
     * @return string
     */
    public function url():string
    {
        return $this->url;
    }

    /**
     * Get value from $_POST by the given parameter
     *
     * @param  string $parameter
     * @param  mixed  $default
     *
     * @return mixed
     */
    public function post(string $parameter, $default = null)
    {
        //Remove any white space from inputs
        $value = array_get($_POST, $parameter, $default);

        if (is_array($value)) {
            $value = array_filter($value);
        } else {
            $value = trim($value);
        }

        return $value;
    }

    /**
     * Set Value To $_POST For the given key
     *
     * @param string $key
     * @param mixed $valuet
     *
     * @return mixed
     */
    public function setPost(string $key, $value)
    {
        $_POST[$key] = $value;
    }

    /**
     * Get value from _GET by the given parameter
     *
     * @param  string  $parameter
     * @param  mixed   $default
     *
     * @return mixed
     */
    public function get(string $parameter, $default = null)
    {
        // just remove any white space if there is a value
        $value = array_get($_GET, $parameter, $default);

        if (is_array($value)) {
            $value = array_filter($value);
        } else {
            $value = trim($value);
        }

        return $value;
    }

    /**
     * Get full base Url of the script
     *
     * @return string
     */
    public function baseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * Get current Request Method
     *
     * @return string
     */
    public function method(): string
    {
        return $this->server('REQUEST_METHOD');
    }

    /**
     * Get the referer link
     *
     * @return string
     */
    public function referer(): string
    {
        return $this->server('HTTP_REFERER');
    }

    /**
     * Get value from _SERVER by the given key
     *
     * @param  string $key
     * @param  mixed $default
     *
     * @return mixed
     */
    public function server(string $key, $default = null)
    {
        return array_get($_SERVER, $key, $default);
    }
}