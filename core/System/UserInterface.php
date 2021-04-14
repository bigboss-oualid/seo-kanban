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


Interface UserInterface
{
    /**
     * @return int
     */
    public function getUserRoleId(): int;

    /**
     * @param int $userRoleId
     *
     * @return self
     */
    public function setUserRoleId(int $userRoleId): self;

    /**
     * @param int $id
     *
     * @return self
     */
    public function setId(int $id): self;

    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @return string
     */
    public function getUsername(): string;

    /**
     * @param string $username
     *
     * @return self
     */
    public function setUsername(string $username): self;

    /**
     * @return string
     */
    public function getPassword(): string;

    /**
     * @param string $password
     *
     * @return self
     */
    public function setPassword(string $password): self;

    /**
     * @param string $code
     *
     * @return self
     */
    public function setCode(string $code): self;

    /**
     * @return string
     */
    public function getCode(): string;


}