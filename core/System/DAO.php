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

abstract class DAO
{
    /**
     * Application Object
     *
     * @var Application
     */
    protected Application $app;

    /**
     * Table name
     *
     * @var string|null
     */
    protected ?string $table = null;

    /**
     * Constructor
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;

        $this->table();
    }

    /**
     * Get the name of table
     *
     * @return void
     */
    protected function table(): void
    {
        if (is_null($this->table))
        {
            $parts = explode('\\', get_class($this));
            $class_name = end($parts);

            $this->table = strtolower(str_replace('DAO', '', $class_name));
        }
    }

    /**
     * Call shared Application objects dynamically
     *
     * ´@param string $key
     *
     * @return mixed
     */
    public function __get(string $key)
    {
        return $this->app->get($key);
    }

    /**
     * Determine if the given value of the key exists in the table
     *
     * @param mixed  $value
     * @param string $key
     *
     * @return bool
     */
    public function exists($value, string $key = 'id'): bool
    {
        return (bool) $this->select($key)->where($key . ' = ? ', $value)->fetch($this->table);
    }

    /**
     * Delete record by ID
     *
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id): void
    {
        $this->where('id = ?', $id)->delete($this->table);
    }

    /**
     * Call Database methods dynamically
     *
     * @param  string $method
     * @param  array  $args
     *
     * @return mixed
     */
    public function __call(string $method, array $args)
    {
        return call_user_func_array([$this->app->db, $method], $args);
    }

    /**
     * Get all Model Records
     *
     * @return array
     */
    public function all(): array
    {
        $results = $this->fetchAll($this->table);

        if (!$results){ return [];}

        $data = [];
        $model = $this->getModelClass();

        foreach ($results as $result){
            $data[] = new $model($result);
        }

        return $data;
    }

    /**
     * Get Record by Id
     *
     * @param  int    $id
     *
     * @return mixed
     */
    public function get(int $id)
    {
        $result = $this->where('id = ?', $id)->fetch($this->table);

        if (!$result){ return null;}

        if( !$this->getModelClass()){
            return $result;
        }

        $model = $this->getModelClass();

        return new $model($result);
    }

    /**
     * Create Model name to create new instance
     *
     * @return null|string
     */
    private function getModelClass(): ?string
    {
        $modelName = ucfirst($this->table);
        $modelPath = 'App\\Model\\'.$modelName;

        $relativeViewPath = 'src/Model/'.$modelName.'.php';

        if(!$this->file->exists($relativeViewPath)){
            return null;
        }

        str_replace('/', '\\', $modelPath);

        return $modelPath;
    }

} 