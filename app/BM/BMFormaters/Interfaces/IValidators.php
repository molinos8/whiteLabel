<?php

namespace App\BM\BMFormatters\Interfaces;

/**
 * Interface to validators, all validators must implement this interface
 */
interface IValidators
{
    /**
     * Returns the BMError or maybe some result
     *
     * @return mixed
     */
    public function validationResult();
}
