<?php

namespace Tests;

use App\BM\Validators\WhiteLabelJSONValidator;
use Illuminate\Foundation\Testing\TestCase;
use App\BM\Wrappers\BMErrors;

/**
 * WhiteLabelJSONValidatorTest 
 */
 class WhiteLabelJSONValidatorTest extends TestCase
{

    /**
     * Bad URL.
     *
     * @var string
     */
    protected $badURL = 'http://123asdf123asdf.asdf';


    /**
     * Bad array with no needed attributes.
     *
     * @var array
     */
    protected $badArray = [
        0 => [
            'other' => ['a'=> 1000],
            'other2' => ['a' => 1500]
            ]
        ];
    
    public function createApplication()
    {
        $app = require __DIR__.'/../../../../../bootstrap/app.php';

        $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    /**
     * Test setup.
     *
     * @return void
     */
    public function setup():void
    {       
        parent::__construct();
        $this->createApplication();
        if (!$this->app) {
            $this->refreshApplication();
        }
        $this->createApplication();
        $this->validator = new WhiteLabelJSONValidator();
    }
    /**
     * Test WhiteLabelJSONValidator Class exists
     *
     * @return void
     */
    public function test_WhiteLabelJSONvalidatorClass_Exists():void
    {
        $validator = $this->getMockBuilder(WhiteLabelJSONValidator::class)->disableOriginalConstructor()->getMockForAbstractClass();
        $this->assertInstanceOf(\App\BM\Validators\WhiteLabelJSONValidator::class, $validator);
    }

    /**
     * Test that we get bad url and method checkJsonUrl return BMError.
     *
     * @return void
     */
    public function test_checkJsonUrl_getBadUrl_throwsError():void
    {
        $this->validator->setJsonUrl($this->badURL);
        $returnedByCheck = $this->validator->checkJsonUrl();
        $this->assertInstanceOf(BMErrors::class, $returnedByCheck);
    }

    /**
     * Test that we get good url and method checkJsonUrl return Valida Json.
     *
     * @return void
     */
    public function test_checkJsonUrl_getGoodUrl_returnValidJason():void
    {
        $returnedByCheck = $this->validator->checkJsonUrl();
        $this->assertIsArray($returnedByCheck);
    }

    /**
     * Test that array dont has all needed atributes.
     *
     * @return void
     */  
    public function test_checkJsonHasAllNeededAttributes_dontHasAllNeededAttributes_returnBMErrors():void
    {
        $returnedByChecker = $this->validator->checkJsonHasAllNeededAttributes($this->badArray);
        $this->assertInstanceOf(BMErrors::class, $returnedByChecker);

    }
    /**
     * Test that array has all needed atributes.
     *
     * @return void
     */  
    public function test_checkJsonHasAllNeededAttributes_hasAllNeededAttributes_returnArray():void
    {
        $returnedByCheck = $this->validator->checkJsonUrl();
        $returnedByChecker = $this->validator->checkJsonHasAllNeededAttributes($returnedByCheck);
        $this->assertIsArray($returnedByChecker);
    }


    /**
     * Test that validationResult gets bad url and returns BMError.
     *
     * @return void
     */  
    public function test_validationResult_getsBadUrl_returnBMErrors():void
    {
        $this->validator->setJsonUrl($this->badURL);
        $returnedByChecker = $this->validator->validationResult();
        $this->assertInstanceOf(BMErrors::class, $returnedByChecker);

    }

    /**
     * Test that validationResult gets good url and returns array.
     *
     * @return void
     */  
    public function test_validationResult_getsGoodUrl_returnArray():void
    {
        $returnedByChecker = $this->validator->validationResult();
        $this->assertIsArray($returnedByChecker);
    }


    /**
     * Test tearDown
     *
     * @return void
     */
    protected function tearDown():void
    {
        $config = app('config');
        parent::tearDown();
        app()->instance('config', $config);
    }
}