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

class Validation
{
    /**
     * Application Object
     *
     * @var Application;
     */
    private $app;

    /**
     * Errors container
     *
     * @var array
     */
    private $errors = [];

    /**
     * Constructor
     *
     * @param  Application $app
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Determine if the given input is not empty
     *
     * @param string $inputName
     * @param string $customErrorMessage
     *
     * @return self
     */
    public function required(string $inputName, string $customErrorMessage = null): self
    {
        if ($this->hasErrors($inputName)) {
            return $this;
        }

        $inputValue = $this->value($inputName);

        if ($inputValue === '') {
            $message = $customErrorMessage ?: sprintf('%s is required', ucfirst($inputName));
            $this->addError($inputName, $message);
        }

        return $this;
    }

    /**
     * Determine if the given input must be float
     *
     * @param string $inputName
     * @param string $customErrorMessage
     *
     * @return self
     */
    public function float(string $inputName, string $customErrorMessage = null): self
    {
        if ($this->hasErrors($inputName)) {
            return $this;
        }

        $inputValue = $this->value($inputName);

        if (! is_float($inputValue)) {
            $message = $customErrorMessage ?: sprintf('%s accept only decimal numbers', ucfirst($inputName));
            $this->addError($inputName, $message);
        }

        return $this;
    }

    /**
     * Determine if the given input is valid Email
     *
     * @param string $inputName
     * @param string $customErrorMessage
     *
     * @return self
     */
    public function email(string $inputName, string $customErrorMessage = null): self
    {
        if ($this->hasErrors($inputName)) {
            return $this;
        }

        $inputValue = $this->value($inputName);

        if (! filter_var($inputValue, FILTER_VALIDATE_EMAIL)) {
            $message = $customErrorMessage ?: 'Address mail is not valid';
            $this->addError($inputName, $message);
        }

        return $this;
    }

    /**
     * Determine if the given input is valid Password
     *
     * @param string $inputName
     * @param string $customErrorMessage
     *
     * @return self
     */
    public function password(string $inputName,int $minCharacters = 8, int $maxCharacters = 50, string $customErrorMessage = null): self
    {
        if ($this->hasErrors($inputName)) {
            return $this;
        }

        $inputValue = $this->value($inputName);
        $pattern = '/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{'.$minCharacters.','.$maxCharacters.'}$/';

        if (!preg_match($pattern, $inputValue)) {
            $message = $customErrorMessage ?: 'Your password should have minimum 6 characters:  1 majuscule, 1 minuscule Letter, at least 1 number and 1 special character';
            $this->addError($inputName, $message);
        }

        return $this;
    }

    /**
     * Determine if The given input should be at least the given $length
     *
     * @param string      $inputName
     * @param int         $length
     * @param string|null $customErrorMessage
     *
     * @return self
     */
    public function minLen(string $inputName, int $length, string $customErrorMessage = null): self
    {
        if ($this->hasErrors($inputName)) {
            return $this;
        }

        $inputValue = $this->value($inputName);

        if ( strlen($inputValue) < $length) {
            $message = $customErrorMessage ?: sprintf('%s should have %d  characters minimum ', ucfirst($inputName), $length);
            $this->addError($inputName, $message);
        }

        return $this;
    }

    /**
     * Detrmine if The given input should be at most the given $length
     *
     * @param string      $inputName
     * @param int         $length
     * @param string|null $customErrorMessage
     *
     * @return self
     */
    public function maxLen(string $inputName, int $length, string $customErrorMessage = null): self
    {
        if ($this->hasErrors($inputName)) {
            return $this;
        }

        $inputValue = $this->value($inputName);

        if ( strlen($inputValue) > $length) {
            $message = $customErrorMessage ?: sprintf('%s should have %d  characters maximum', ucfirst($inputName), $length);
            $this->addError($inputName, $message);
        }

        return $this;
    }

    /**
     * Determine if The first input value matches the second input value
     *
     * @param string      $firstInput
     * @param string      $secondInput
     *
     * @param string|null $customErrorMessage
     *
     * @return self
     */
    public function match(string $firstInput, string $secondInput, string $customErrorMessage = null): self
    {
        $firstInputValue = $this->value($firstInput);
        $secondInputValue = $this->value($secondInput);

        if ($firstInputValue != $secondInputValue) {
            $message = $customErrorMessage ?: sprintf('You entered two different %ss !',  $firstInput);
            $this->addError($firstInput, $message);
        }
        return $this;
    }

    /**
     * Determine if the given input is unique in database
     *
     * @param string      $inputName
     * @param array       $databaseData
     * @param string|null $customErrorMessage
     *
     * @return self
     */
    public function unique(string $inputName, array $databaseData, string $customErrorMessage = null): self
    {
        if ($this->hasErrors($inputName)) {
            return $this;
        }

        $inputValue = $this->value($inputName);

        $table = null;
        $column = null;
        $exceptionColumn = null;
        $exceptionColumnValue = null;

        //Email exist in the DB throw Error
        if ( count($databaseData) == 2) {
            list($table, $column) = $databaseData;
        }
        // email exist make exception and continue
        elseif ( count($databaseData) == 4) {
            list($table, $column, $exceptionColumn, $exceptionColumnValue) = $databaseData;
        }

        if ( $exceptionColumn && $exceptionColumnValue) {
            $result = $this->app->db->select($column)
                                    ->from($table)
                                    ->where($column . ' = ? AND ' . $exceptionColumn . ' != ?', $inputValue, $exceptionColumnValue)
                                    ->fetch();
        } else {
            $result = $this->app->db->select($column)
                                    ->from($table)
                                    ->where($column . ' = ?', $inputValue)
                                    ->fetch();
        }

        if($result) {
            $message = $customErrorMessage ?: sprintf('%s already exists', ucfirst($inputName));
            $this->addError($inputName, $message);
        }
        return $this;
    }

    /**
     * Add custom message
     *
     * @param string $message
     *
     * @return self
     */
    public function message(string $message): self
    {
        $this->errors[] = $message;

        return $this;
    }

    /**
     * Validate all the inputs
     *
     * @return self
     */
    public function validate(): self
    {
        return $this;
    }

    /**
     * Determine if there are any invalid inputs
     *
     * @return boolean
     */
    public function fails(): bool
    {
        return !empty($this->errors);
    }

    /**
     * Determine if all inputs are valid
     *
     * @return boolean
     */
    public function passes(): bool
    {
        return empty($this->errors);
    }

    /**
     * Get all errors message for all inputs
     *
     * @return array
     */
    public function getMessages(): array
    {
        return $this->errors;
    }

    /**
     * Display errors message one after another
     *
     * @return string
     */
    public function detachMessages(): string
    {
        return implode('<br>', $this->errors);
    }

    /**
     * Get the value for the given input name
     *
     * @param string $input
     *
     * @return mixed
     */
    private function value(string $input)
    {
        return $this->app->request->post($input);
    }

    /**
     * Add input error
     *
     * @param string $inputName
     * @param string $errorMessage
     *
     * @return void
     */
    private function addError(string $inputName, string $errorMessage): void
    {
        $this->errors[$inputName] = $errorMessage;
    }

    /**
     * Determine if the given input has previous errors
     *
     * @param string $inputName
     *
     * @return boolean
     */
    private function hasErrors(string $inputName): bool
    {
        return array_key_exists($inputName, $this->errors);
    }
}