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

class Html
{
    /**
     * Application Object
     *
     * @var Application
     */
    protected Application $app;

    /**
     * Html Title
     *
     * @var string|null
     */
    private ?string $title;

    /**
     * Html Description
     *
     * @var string|null
     */
    private ?string $description;

    /**
     * Html Keywords
     *
     * @var string|null
     */
    private ?string $keywords;

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
     * Set Title
     *
     * @param string|null $title
     *
     * @return void
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * Get Title
     *
     * @return string|null Title
     */
    public function title(): ?string
    {
        return $this->title;
    }

    /**
     * Set Description
     *
     * @param string|null $description
     *
     * @return void
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * Get Description
     *
     * @return string|null
     */
    public function description(): ?string
    {
        return $this->description;
    }

    /**
     * Set Keywords
     *
     * @param string|null $keywords
     *
     * @return void
     */
    public function setKeywords(?string $keywords): void
    {
        $this->keywords = $keywords;
    }

    /**
     * Get Keywords
     *
     * @return string|null
     */
    public function Keywords(): ?string
    {
        return $this->keywords;
    }
} 