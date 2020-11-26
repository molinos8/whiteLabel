<?php

namespace app\BM\Repositories;


use App\BM\Wrappers\BMErrors;
use App\BM\BMFormatters\Interfaces\IWhiteLabelRepository;
use App\BM\BMFormatters\Interfaces\IValidators;


/**
 * Features repository implemente IWhiteLabelRepository
 */
class WhiteLabelRepository implements IWhiteLabelRepository
{
    /**
     * json IValidators
     *
     * @var App\BM\BMFormatters\Interfaces\IValidators
     */
    private $jsonValidator;

    /**
     * Thumbs pattern
     *
     * @var array
     */
    private $pattern = [6,18,30,42,54];

    /**
     * array ordered using pattern
     *
     * @var array
     */
    private $reorderArray;

    /**
     * class constructor
     *
     */    
    public function __construct(IValidators $jsonValidator)
    {
        $this->jsonValidator = $jsonValidator;

    }

    /**
     * Reoder webCam array following pattern
     *
     * @return array $webCamArray webCam array
     */
    public function reorderWebCamArrayFollowingPattern():array
    {
        $webCamArray=$this->jsonValidator->validationResult();
        for ($x = 0; $x <= count($this->pattern)-1; $x++) {
            array_splice( $webCamArray, $this->pattern[$x], 0, array($webCamArray[$x]) );        
        }
        array_splice( $webCamArray, 0, 1);
        $this->reorderArray = $webCamArray;
        return $webCamArray;
    }

    /**
     * Return a webcam by its postion
     *
     * @param int $position position of webcam
     * 
     * @return array $webCam single webCam
     */  
    public function returnCompleteWebcamFromDeterminatePosition($position):int
    {
        $webCam = $this->jsonValidator->validationResult();
        return $webCam[$position];
    }

    /**
     * Return only needed values, adds size of the thumb
     * 
     * @return array $webCam formated array
     */  
    public function returnFormatedWebcamArray():array
    {
        foreach ($this->reorderArray as $webCamKey => $webCam) {
            $newOrderArray[$webCamKey]['wbmerThumb4']= $webCam['wbmerThumb4'];
            $newOrderArray[$webCamKey]['wbmerThumb2']= $webCam['wbmerThumb2'];
            $newOrderArray[$webCamKey]['wbmerNick']= $webCam['wbmerNick'];
            $newOrderArray[$webCamKey]['size']= 'small'; 
            if(in_array($webCamKey+1, $this->pattern)) {
                $newOrderArray[$webCamKey]['size']= 'big';     
            }
        }
        return $newOrderArray;


    }

    /**
     * Checks if validator have errors
     * 
     * @return mixed
     */ 
    public function checkForValidatorBMErrors()
    {
        if($this->jsonValidator->validationResult() instanceof BMErrors) {
            return $this->jsonValidator->validationResult();
        }
        return false;
    }

    /**
     * returns value for BM
     * 
     * @return array $result formated value for BM
     */ 
    public function constructReadyFormatedArrayForBM():array
    {
        $this->reorderWebCamArrayFollowingPattern();
        $result = $this->returnFormatedWebcamArray();

        return $result;
    }


}