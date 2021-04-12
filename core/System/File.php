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

class File
{
    /**
     * Place the default Directory Separator from operating system
     *
     * @const string
     */
    const DS = DIRECTORY_SEPARATOR;

    /**
     * Root Path
     *
     * @var string
     */
    private string $root;

    /**
     * Constructor
     *
     * @param string $root
     */
    public function __construct(string $root)
    {
        $this->root = $root;
    }

    /**
     * Determine whether the given file path exists
     *
     * @param  string $file
     *
     * @return bool
     */
    public function exists(string $file): bool
    {
        return file_exists($this->to($file));
    }

    /**
     * Require the given file
     *
     * @param  string $file
     *
     * @return mixed
     */
    public function call(string $file)
    {
        return require_once $this->to($file);
    }

    /**
     * Generate full path to the given path and separate the folders with the default DS of operating system
     *
     * @param  string $path
     *
     * @return string
     */
    public function to(string $path): string
    {
        return $this->root . static::DS . str_replace(['/', '\\'], static::DS, $path);
    }

    /**
     * Generate full path to the given path in public folder
     *
     * @param  string $path
     *
     * @return string
     */
    public function toPublic(string $path): string
    {
        return $this->to('public/' . $path);
    }
}