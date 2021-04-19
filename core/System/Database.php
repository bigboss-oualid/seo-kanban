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

use PDO;
use PDOException;
use PDOStatement;
use stdClass;


class Database
{
    const WHERE = ' WHERE ';

    /**
     * Application Object
     *
     * @var Application
     */
    private Application $app;

    /**
     * PDO Connection
     *
     * @var PDO|null
     */
    private static PDO $connectionDb;

    /**
     * Table name
     *
     * @var null|string
     */
    private ?string $table = null;

    /**
     * Data Container that will be stored in database
     *
     * @var string array
     */
    private $data = [];

    /**
     * Bindings Container used in bindValue()
     *
     * @var array
     */
    private array $bindings = [];

    /**
     * Last Insert ID after insert query
     *
     * @var int|null
     */
    private ?int $lastId;

    /**
     * Wheres clause container
     *
     * @var array
     */
    private array $wheres = [];

    /**
     * Having clause container
     *
     * @var array array
     */
    private array $havings = [];

     /**
     * Group By clause container
     *
     * @var array
     */
    private array $groupBy = [];

    /**
     * Determine which column(s) will be selected
     *
     * @var array
     */
    private array $selects = [];

    /**
     * Limit the number of returned records
     *
     * @var int|null
     */
    private ?int $limit = 0;

    /**
     * Start Getting records from this offset
     *
     * @var int|null
     */
    private ?int $offset = 0;

    /**
     * Total Rows
     *
     * @var int
     */
    private int $rows = 0;

    /**
     * Container for join clause
     *
     * @var array
     */
    private array $joins = [];

    /**
     * Order the records
     *
     * @var array
     */
    private array $orderBy = [];

    /**
     * Constructor
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;

        if (! $this->isConnected()) {
            $this->connect();
        }
    }

    /**
     * Determine if there is any connection to database
     *
     * @return boolean
     */
    private function isConnected(): bool
    {
        return isset(static::$connectionDb) ? static::$connectionDb instanceof PDO : false;
    }

    /**
     * Connect to database
     *
     * @return void
     */
    private function connect(): void
    {
        $connectionData = $this->app->file->call('config/db_connection.php');

        try {
            static::$connectionDb = new PDO('mysql:host=' . $connectionData['server'] . ';dbname=' . $connectionData['dbName'], $connectionData['user'], $connectionData['pass']);
            static::$connectionDb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    /**
     * Get Database Connection object PDO Object
     *
     * @return PDO
     */
    public function connectionDb(): PDO
    {
        return static::$connectionDb;
    }


    /**
     * Fetch Table, this will return only one record
     *
     * @param string $table
     *
     * @return  array|bool
     */
    public function fetch(string $table = null)
    {
        if($table) {
            $this->table($table);
        }
        $sql = $this->fetchStatement();
        $result = $this->query($sql, $this->bindings)->fetch();
        $this->reset();

        return $result;
    }

    /**
     * Fetch All Records from Table
     *
     * @param string $table
     *
     * @return array
     */
    public function fetchAll(string $table = null): array
    {
        if($table) {
            $this->table($table);
        }

        $sql = $this->fetchStatement();

        $query = $this->query($sql, $this->bindings);

        $results = $query->fetchAll();

        $this->rows = $query->rowCount();

        $this->reset();

        return $results;
    }

    /**
     * Set the table name
     *
     * @param string $table
     *
     * @return self
     */
    public function table(string $table): self
    {
        $this->table = $table;
        return $this;
    }

    /**
     * Set the table name
     *
     * @param string $table
     *
     * @return self
     */
    public function from(string $table): self
    {
        $this->table($table);

        return $this;
    }

    /**
     * Get the last insert id
     * @return int
     */
    public function lastId(): int
    {
        return $this->lastId;
    }

    /**
     * Set the Data that will be stored in the database table
     *
     * @param mixed $key
     * @param mixed $value
     *
     * @return self
     */
    public function data($key, $value = null): self
    {
        if (is_array($key)) {
            $this->data = array_merge($this->data, $key);

            $this->addToBindings($key);
        }else {
            $this->data[$key] = $value;

            $this->addToBindings($value);
        }

        return $this;
    }

    /**
     * Insert Data to database
     *
     * @param string $table
     *
     * @return self
     */
    public function insert(string $table = null): self
    {
        if($table) {
            $this->table($table);
        }

        $sql = 'INSERT INTO ' . $this->table . ' SET ';

        $sql .= $this->setFields();

        $this->query($sql, $this->bindings);

        $this->lastId = $this->connectionDb()->lastInsertId();

        $this->reset();

        return $this;
    }

    /**
     * Update Data in database
     *
     * @param string $table
     *
     * @return self
     */
    public function update(string $table = null):self
    {
        if($table) {
            $this->table($table);
        }

        $sql = 'UPDATE ' . $this->table . ' SET ';

        $sql .= $this->setFields();

        if ($this->wheres) {
            $sql .= self::WHERE. implode(' ', $this->wheres);
        }

        $this->query($sql, $this->bindings);

        $this->reset();

        return $this;
    }

    /**
     * delete Data in database
     *
     * @param string $table
     *
     * @return self
     */
    public function delete(string $table = null):self
    {
        if($table) {
            $this->table($table);
        }

        $sql = 'DELETE FROM ' . $this->table . '';

        if ($this->wheres) {
            $sql .= self::WHERE. implode(' ', $this->wheres);
        }

        $this->query($sql, $this->bindings);

        $this->reset();

        return $this;
    }

    /**
     * Set Select clause
     *
     * @param string $select
     *
     * @return self
     */
    public function select(...$select): self
    {
        $this->selects = array_merge($this->selects, $select);

        return $this;
    }

    /**
     * Set Join clauses
     *
     * @param string $join
     *
     * @return self
     */
    public function join(string $join): self
    {
        $this->joins[] = $join;

        return $this;
    }

    /**
     * Set Order By clause
     *
     * @param string $orderBy default value = 'ASC'
     * @param string $sort
     *
     * @return self
     */
    public function orderBy(string $orderBy, string $sort = 'ASC'): self
    {
        $this->orderBy = [$orderBy, $sort];

        return $this;
    }

    /**
     * Set Limit & Offset
     *
     * @param int $Limit
     * @param int $offset
     *
     * @return self
     */
    public function limit(int $limit, int $offset = 0): self
    {
        $this->limit = $limit;
        $this->offset = $offset;

        return $this;
    }

    /**
     * Execute the given sql statement
     *
     * @param mixed
     *
     * @return mixed
     */
    public function query(...$bindings)
    {
        $sql = array_shift($bindings);
        //if i send bindings as one array ex:query('SELECT * FROM episodes WHERE id > ? AND id < ?', [1,5]);
        if (count($bindings) == 1 && is_array($bindings[0])) {
            $bindings = $bindings[0];
        }

        try {
            $query = $this->connectionDb()->prepare($sql);

            foreach ($bindings as $key => $value) {
                $query->bindValue($key + 1, _escape($value));
            }
            $query->execute();

            return $query;

        } catch (PDOException $e) {
            echo $sql;

            pre($this->bindings,false);

            die($e->getMessage());
        }
    }

    /**
     * Add the given value to bindings
     *
     * @param mixed $value
     *
     * @return void
     */
    private function addToBindings($value): void
    {

        if (is_array($value)) {
            $this->bindings = array_merge($this->bindings, array_values($value));
        } else {
            $this->bindings[] = $value;
        }
    }

    /**
     * Get total rows after fetch all statement
     *
     * @return int
     */
    public function rows(): int
    {
        return $this->rows;
    }

    /**
     * Prepare select Statement
     *
     * @return string
     */
    private function fetchStatement(): string
    {
        $sql = 'SELECT ';

        if($this->selects) {
            $sql .= implode(',' , $this->selects);
        } else {
            $sql .= '*';
        }
        $sql .= ' FROM ' . $this->table . ' ';

        if($this->joins) {
            $sql .= implode(' ' , $this->joins);
        }

        if($this->wheres) {
            $sql .= self::WHERE. implode(' ' , $this->wheres) . ' ';
        }

        if ($this->havings) {
            $sql .= ' HAVING ' . implode(' ', $this->havings) . ' ';
        }

        if($this->orderBy) {
            $sql .= ' ORDER BY ' . implode(' ' , $this->orderBy);
        }

        if($this->limit) {
            $sql .= ' LIMIT ' . $this->limit;
        }

        if($this->offset) {
            $sql .= ' OFFSET ' . $this->offset;
        }

        if ($this->groupBy) {
            $sql .= ' GROUP BY ' . implode(' ' , $this->groupBy);
        }

        return $sql;
    }

    /**
     * Set the Fields for insert and update
     *
     * @return string
     */
    private function setFields(): string
    {
        $sql  = '';

        foreach (array_keys($this->data) as $key) {
            $sql .= '`' . $key . '` = ? , ';
        }

        return rtrim($sql, ', ');
    }

    /**
     * Add new where clause
     *
     * @param  array $bindings
     *
     * @return self
     */
    public function where(...$bindings): self
    {
        $sql = array_shift($bindings);

        $this->addToBindings($bindings);

        $this->wheres[] = $sql;

        return $this;
    }

    /**
     * Add New Having clause
     *
     * @return self
     */
    public function having(): self
    {
        $bindingsFunction = func_get_args();

        $sql = array_shift($bindingsFunction);

        $this->addToBindings($bindingsFunction);

        $this->havings[] = $sql;

        return $this;
    }

    /**
     * Group By Clause
     *
     * @param array $arguments
     *
     * @return self
     */
    public function groupBy(...$arguments): self
    {
        $this->groupBy = $arguments;

        return $this;
    }

    private function reset(): void
    {
        $this->table = null;
        $this->limit = null;
        $this->offset = null;
        $this->data = [];
        $this->bindings = [];
        $this->wheres = [];
        $this->havings = [];
        $this->groupBy = [];
        $this->joins = [];
        $this->selects = [];
        $this->orderBy = [];
    }
}
