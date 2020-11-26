<?php

namespace App\BM\BMFormatters\Interfaces;

/**
 * Interface to format BM errors. All BM errors must implement this class
 */
interface IBMErrors
{
    /**
     * Returns the code of ther error
     *
     * @return string
     */
    public function getCode():string;
    /**
     * Returns a short description of the error
     *
     * @return string
     */
    public function getTitle():string;
    /**
     * Returns a long description of the error
     *
     * @return string
     */
    public function getDescription():string;
    /**
     * Returns an array with error verbose
     *
     * @return array
     */
    public function getSource():array;
    
    /*
     * Returns a list of related errors
     *
     * @return array
     */
    public function getErrors():array;
}
