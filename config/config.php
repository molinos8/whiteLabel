<?php

return [
    /*
    |--------------------------------------------------------------------------
    | WhiteLabel JSON URL
    |--------------------------------------------------------------------------
    |
    | Webcams JSON URL
    |
    */  
    'whiteLabelJsonUrl' => 'http://webcams.cumlouder.com/feed/webcams/online/56/1/',

    /*
    |--------------------------------------------------------------------------
    | Validators error code
    |--------------------------------------------------------------------------
    |
    | 3 digit string code to identify validator errors
    |
    */  
    'validatorErrorCode' => '999',
    /*
    |--------------------------------------------------------------------------
    | Models error code
    |--------------------------------------------------------------------------
    |
    | 3 digit string code to identify models errors
    |
    */  
    'modelErrorCode' => '001',

    /*
    |--------------------------------------------------------------------------
    | WebCam thumb URL base
    |--------------------------------------------------------------------------
    |
    | url to join with webCam thumb img
    |
    */  
    'webCamThumbImgUrl' => 'http://w0.imgcm.com/modelos/',

    /*
    |--------------------------------------------------------------------------
    | Nats codes
    |--------------------------------------------------------------------------
    |
    | Nats codes for affiliates
    |
    */  
    'natsCode' => ['cerdas.com' => 'ABCDE', 'babosas.com' => 'FGHI', 'conejox.com' =>'JKLM', '127.0.0.1' => 'NÑOPQ'],
    
    /*
    |--------------------------------------------------------------------------
    | Google analytics
    |--------------------------------------------------------------------------
    |
    | Google analytics codes for affiliates
    |
    */  
    'GACode' => ['cerdas.com' => 'google1', 'babosas.com' => 'google2', 'conejox.com' =>'google3', '127.0.0.1' => 'google4'],

    /*
    |--------------------------------------------------------------------------
    | Affiliates name
    |--------------------------------------------------------------------------
    |
    | Affiliates name
    |
    */  
    'affiliateName' => ['cerdas.com' => 'cerdas', 'babosas.com' => 'babosas', 'conejox.com' =>'conejox', '127.0.0.1' => 'conejox'],  

    /*
    |--------------------------------------------------------------------------
    | WebCam URL base
    |--------------------------------------------------------------------------
    |
    | url to join with name and nats code to link with webcam
    |
    */  
    'webCamUrlBase' => 'http://webcams.cumlouder.com/joinmb/cumlouder/',
];