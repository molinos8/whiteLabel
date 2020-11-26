<?php

namespace app\BM;

use App\BM\BMFormatters\Interfaces\IModels;
use App\BM\Wrappers\BMErrors;
use app\BM\BMFormatters\Interfaces\IWhiteLabelRepository;

class WhiteLabel implements IModels
{
    /**
     * Id of the Business Model
     *
     * @var int
     */
    private $entityId = '001';

     /**
     * Nanme of the Business Model
     *
     * @var string
     */
    private $BMName = 'whiteLabel';  

    /**
     * Repository of whiteLabel
     *
     * @var \App\BM\Repositories\WhiteLabelRepository;
     */
    private $repository;

    /**
     * Afilliate identifier
     *
     * @var string afilliate;
     */
    private $affiliate;

    /**
     * Afilliate nats code
     *
     * @var string afilliateNatsCode;
     */

    private $afilliateNatsCode;

    /**
     * Status codes
     *
     * @var array
     */
    const STATUS_CODES = [
        'wrongAffiliate' => '001',
    ];


    /*
     * Constructor of the BM
     */
    public function __construct(IWhiteLabelRepository $repository,string $affiliate)
    {
        $this->repository = $repository;
        $this->affiliate = $affiliate;
    }

    /**
     * Core of BM
     *
     * @return mixed array formated list for the view or BMErrors
     */
    public function returnWebCamsValues()
    {

        if(!$this->checkForValidJson()) {
            return $this->checkForValidJson();
        }
        $this->getNatCodeForAffiliate();
        if(!$this->checkForValidJson()) {
            return $this->checkForValidJson();
        }
        if(!$this->validateAffiliate()) {
            return $this->validateAffiliate();
        }
        $webCamDataArray = $this->repository->constructReadyFormatedArrayForBM();

        return $this->addUrlsToWebCamDataArray($webCamDataArray);
    }

    /**
     * Return the main id of the WhiteLabel model
     *
     * @return string
     */
    public function getId():string
    {
        return $this->entityId;
    }  

    /**
     * Add url to a given web can data array
     *
     * @return array formated array with correct urls
     */   
    public function addUrlsToWebCamDataArray($webCamDataArray)
    {
        foreach ($webCamDataArray as $webCamKey => $webCam) {
            $newWebCamDataArray[$webCamKey]['wbmerThumb4'] = $this->generateThumbUrl($webCam['wbmerThumb4']);
            $newWebCamDataArray[$webCamKey]['wbmerThumb2'] = $this->generateThumbUrl($webCam['wbmerThumb2']);
            $newWebCamDataArray[$webCamKey]['wbmerNick'] = $webCam['wbmerNick'];
            $newWebCamDataArray[$webCamKey]['wbmerLink'] = $this->generateWebCamUrl($webCam['wbmerNick']);
            $newWebCamDataArray[$webCamKey]['size'] = $webCam['size'];
        }
        return $newWebCamDataArray;
    }  

    /**
     * generate the thumb url
     *
     * @return string complet thumb url
     */  
    public function generateThumbUrl($thumbUrl):string
    {
        return config('config.webCamThumbImgUrl').$thumbUrl;
    }

    /**
     * Check if repository has valid json
     *
     * @return mixed BMerror | true
     */      
    public function checkForValidJson()
    {
        if($this->repository->checkForValidatorBMErrors() instanceof BMErrors) {
            return $this->repository->checkForValidatorBMErrors();
        }
        return true;
    }

   /**
     * Validates given affiliated domain
     *
     * @return mixed BMerror | true
     */      
    public function validateAffiliate()
    {
        if(array_key_exists($this->affiliate, config('config.natsCode'))) {
            return true;
        }
        return new BMErrors('WhiteLabel', config('config.modelErrorCode').$this->entityId.self::STATUS_CODES['wrongAffiliate'], 'We cant find affiliate', 'given affiliate not in config', ['check affiliate in config.php',$this->affiliate ], []);
    }

     /**
     * Return affiliated nats code
     *
     * @return string affiliated nats code
     */   
    public function getNatCodeForAffiliate():string
    {
        $affiliatedsConfig = config('config.natsCode');
        $this->afilliateNatsCode = $affiliatedsConfig[$this->affiliate];
        return $affiliatedsConfig[$this->affiliate];
    }


    /**
     * Return affiliated GA code
     *
     * @return string affiliated GA code
     */   
    public function returnGoogleAnalitics():string
    {
        $affiliatedsConfig = config('config.GACode');
        return $affiliatedsConfig[$this->affiliate];
    }   

    /**
     * Return affiliated name
     *
     * @return string affiliated name
     */   
    public function returnAffiliateName():string
    {
        $affiliatedsConfig = config('config.affiliateName');
        return $affiliatedsConfig[$this->affiliate];
    }    

    /**
     * Return the BM name
     * 
     * @param string $girlName girls nick
     *
     * @return string girls name with webcam url base and nats code
     */
    public function generateWebCamUrl($girlName):string
    {
        return config('config.webCamUrlBase').$girlName.'/?nats='.$this->afilliateNatsCode;
    }
    
    /**
     * Return the BM name
     *
     * @return string BM name
     */
    public function getBMName():string
    {
        return $this->BMName ;
    }
    
}