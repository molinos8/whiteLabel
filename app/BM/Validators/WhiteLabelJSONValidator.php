<?php

namespace App\BM\Validators;

use App\BM\Wrappers\BMErrors;
use App\BM\BMFormatters\Interfaces\IValidators;
use Exception;

class WhiteLabelJSONValidator implements IValidators
{
    /**
     * Validator code for errors
     *
     * @var string
     */
    const validatorCode = '001';

    /**
     * Status codes
     *
     * @var array
     */
    const STATUS_CODES = [
        'badURL' => '001',
        'notPresentAttribute' => '002'
    ];

    /**
     * JSON URL
     *
     * @var string
     */
    private $jsonUrl;

    /**
     * Constructor
     */
    public function __construct(){
        $this->jsonUrl = config('config.whiteLabelJsonUrl');
    }

    /**
     * Setter for JsonUrl
     *
     * @param string $url JSON URL
     */ 
    public function setJsonUrl($url):string
    {
        $this->jsonUrl = $url;
    }
 
    /**
     * check if given url returns valid JSON
     * 
     * @return mixed BMErrors / array
     */    
    public function checkJsonUrl()
    {
        try {
            $json = file_get_contents($this->jsonUrl);
            $json = json_decode($json,true);
        } catch(Exception $e) {
            return new BMErrors('WhiteLabelJSONValidator', config('config.validatorErrorCode').self::validatorCode.self::STATUS_CODES['badURL'], 'We cant find valid json', $e->getMessage(), ['Check config whiteLabelJsonUrl url exists','Check this url hace valid JSON',$this->jsonUrl], []);
        }
        return $json;
    }

    /**
     * check if given array has wnerId attribute
     * 
     * @param mixed $arraToCheck BMerrors / array
     * 
     * @return mixed BMErrors / array
     */   
    public function checkJsonHasAllNeededAttributes($arrayToCheck)
    {
        if($arrayToCheck instanceof BMErrors) {
            return $arrayToCheck;
        }
        if(!array_key_exists('wbmerId',$arrayToCheck[0])) {
            return new BMErrors('WhiteLabelJSONValidator', config('config.validatorErrorCode').self::validatorCode.self::STATUS_CODES['notPresentAttribute'], 'We cant find wbmerId key', 'one or more attributes not present', ['check the array attributes'], []);
        } 
        
        return $arrayToCheck;
    }

    /**
     * returns validated value

     * 
     * @return mixed BMErrors / array
     */    
    public function validationResult()
    {
        return $this->checkJsonHasAllNeededAttributes($this->checkJsonUrl());
    }
}