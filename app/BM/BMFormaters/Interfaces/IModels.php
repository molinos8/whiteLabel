<?php

namespace App\BM\BMFormatters\Interfaces;

/**
 * Interface to format a Bussines model class. Must be implemented for each business model to represent the data.
 */
interface IModels
{
    /**
     * Returns the entity id of the business model
     *
     * @return int
     */
    public function getId():string;


    /**
     * Returns the entity id of the business model
     *
     * @return int
     */
    public function getBMName():string;
}