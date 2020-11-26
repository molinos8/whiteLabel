<?php

namespace app\BM\Wrappers;

use App\BM\BMFormatters\Interfaces\IBMErrors;

class BMErrors implements IBMErrors
{
    private $errors;
    private $name;
    private $code;
    private $title;
    private $description;
    private $source;

    /**
     * Create new BM error
     *
     * @param string $name         Name of Business Model
     * @param string $code         The internal code status of the error (business model id + error code)
     * @param string $title        A short description of the error
     * @param string $description  A long description of the error
     * @param array  $source       A list with error debug verbose (for dev environments)
     * @param array  $errors       List of errors that can be associated with the error
     */
    public function __construct(string $name, string $code, string $title, string $description, array $source, array $errors = [])
    {
        $this->errors = $errors;
        $this->code = $code;
        $this->title = $title;
        $this->description = $description;
        $this->source = $source;
        $this->name = $name;
    }

    /**
     * Returns BM name
     *
     * @return array
     */
    public function getName():string
    {
        return $this->name;
    }

    /**
     * Returns a list of errors that can be associated with the error
     *
     * @return array
     */
    public function getErrors():array
    {
        return $this->errors;
    }

    /**
     * Returns the error code 
     *
     * @return string
     */
    public function getCode():string
    {
        return $this->code;
    }
    /**
     * Returns a short description of the error
     *
     * @return string
     */
    public function getTitle():string
    {
        return $this->title;
    }
    /**
     * Returns a long description of the error
     *
     * @return string
     */
    public function getDescription():string
    {
        return $this->description;
    }
    /**
     * Returns an array with error verbose
     *
     * @return array
     */
    public function getSource():array
    {
        return $this->source;
    }

    /**
     * Set a list of related errors
     *
     * @param array $errors related errors
     *
     * @return void
     */
    public function setErrors(array $errors)
    {
        $this->errors = $errors;
    }

    /**
     * Set the code result of the error
     *
     * @param string $code The error code
     *
     * @return void
     */
    public function setCode(string $code)
    {
        $this->code = $code;
    }
    /**
     * Set a short description of the error
     *
     * @param string $title The short description of the error
     *
     * @return void
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }
    /**
     * Set a long description of the error
     *
     * @param string $description The long description of the error
     *
     * @return void
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }
    /**
     * Set an array with error verbose
     *
     * @param array $source List of sources/verbose
     *
     * @return void
     */
    public function setSource(array $source)
    {
        $this->source = $source;
    }

    /**
     * Set the name of the business model
     *
     * @param string $name The name of the action
     *
     * @return void
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

}