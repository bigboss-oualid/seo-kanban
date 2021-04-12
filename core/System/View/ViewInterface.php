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

namespace System\View;

interface ViewInterface
{
    /**
     * Generate the output of the view path and get it
     *
     * @return string
     */
    public function getOutput(): string;

    /**
     * convert the "System\View\View" object to string in printing
     * i.e echo $object
     *
     * @return
     */
    public function __toString(): string;

}