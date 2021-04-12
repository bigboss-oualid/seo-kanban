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

use System\Application;

class Response
{
    /**
     * Application Object
     *
     * @var Application
     */
    private Application $app;

    /**
     * Headers container that will be send to the browser
     *
     * @var array
     */
    private array $headers = [];

    /**
     * the Content that will be sent to the browser
     *
     * @var string
     */
    private string $content = '';

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
     * Set the response output content
     *
     * @param string $content
     *
     * @return void
     */
    public function setOutput(string $content): void
    {
        $this->content = $content;
    }

    /**
     * Add new header that will be sent to the browser
     *
     * @param  $header
     * @param  $value
     *
     * @return void
     */
    public function setHeader(string $header, string $value): void
    {
        $this->headers[$header] = $value;
    }

    /**
     * Send the response Headers
     *
     * @return void
     */
    private function sendHeaders(): void
    {
        foreach ($this->headers as $header => $value) {
            header($header . ':' . $value);
        }
    }

    /**
     * Send the response output
     *
     * @return void
     */
    private function sendOutput(): void
    {
        echo $this->content;
    }

    /**
     * Send the response headers & content
     *
     * @return void
     */
    public function send(): void
    {
        $this->sendHeaders();

        $this->sendOutput();
    }
}