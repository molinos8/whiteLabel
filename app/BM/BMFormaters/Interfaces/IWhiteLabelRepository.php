<?php

namespace App\BM\BMFormatters\Interfaces;

/**
 * Interface to white label repository, all new abstraction layer for whiteLabel must implement this interface
 */
interface IWhiteLabelRepository
{
    /**
     * Returns formated array of webcams ready for view
     *
     * @return array
     */
    public function constructReadyFormatedArrayForBM():array;

    /**
     * Check if repository has valid json
     *
     * @return mixed BMerror | true
     */    
    public function checkForValidatorBMErrors();
}
