<?php

namespace Tests;

use App\BM\Repositories\WhiteLabelRepository;
use Illuminate\Foundation\Testing\TestCase;
use App\BM\Wrappers\BMErrors;
use App\BM\Validators\WhiteLabelJSONValidator;

/**
 * WhiteLabelRepository repository test
 */
class WhiteLabelRepositoryTest extends TestCase
{

    /**
     * Valid fake array for whitLabelRepository
     *
     * @var array
     */
    protected $webCamFakeData = 
        [
        0 => [
            'wbmerId' => '31840',
            'wbmerThumb4' => '3d34412bed40ee22ab54781965e588ca.jpg'
            ],
        1 => [
            'wbmerId' => '31841',
            'wbmerThumb4' => '3d34412bed40ee22ab54781965e588ca.jpg'
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
        $this->validatorStub = $this->getMockBuilder(WhiteLabelJSONValidator::class)->getMock();  
        $this->repository = new WhiteLabelRepository($this->validatorStub);
    }

    /**
     * Test WhiteLabelRepository Class exists
     *
     * @return void
     */
    public function test_WhiteLabelRepositoryClass_Exists():void
    {
        $repository = $this->getMockBuilder(WhiteLabelRepository::class)->disableOriginalConstructor()->getMockForAbstractClass();
        $this->assertInstanceOf(\App\BM\Repositories\WhiteLabelRepository::class, $repository);
    }



    /**
     * Test return complete webcam from determinate position returns that webcam
     *
     * @return void
     */
    public function test_returnCompleteWebcamFromDeterminatePosition_getPosition_returnThisPosition():void
    {
        $testPosition = 0;
        $expectedResult = ['wbmerId' => '31840','wbmerThumb4' => '3d34412bed40ee22ab54781965e588ca.jpg'];
        $this->validatorStub->method('validationResult')->willReturn($this->webCamFakeData);
        $repository = new WhiteLabelRepository($this->validatorStub,null);
        $result = $repository->returnCompleteWebcamFromDeterminatePosition($testPosition);
        $this->assertEquals($result,$expectedResult);

    }

    public function test_reorderWebCamArrayFollowingPattern_getWebCamArray_reorderItFollowingPattern()
    {
        $webCamArray= [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56];
        $webCamArrayExpected= [1,2,3,4,5,0,6,7,8,9,10,11,12,13,14,15,16,1,17,18,19,20,21,22,23,24,25,26,27,2,28,29,30,31,32,33,34,35,36,37,38,3,39,40,41,42,43,44,45,46,47,48,49,4,50,51,52,53,54,55,56];
        $this->validatorStub->method('validationResult')->willReturn($webCamArray);
        $repository = new WhiteLabelRepository($this->validatorStub,null);    
        $result = $repository->reorderWebCamArrayFollowingPattern();
        $this->assertEquals($result,$webCamArrayExpected);
    }

    public function test_checkForValidatorBMErrors_findBMerrors_returnBMErrors()
    {
        $BMError = new BMErrors('fake','000','fake','fake',[],[]);
        $this->validatorStub->method('validationResult')->willReturn($BMError);
        $repository = new WhiteLabelRepository($this->validatorStub,null);
        $result = $repository->checkForValidatorBMErrors();
        $this->assertInstanceOf(BMErrors::class,$result);
    }

    public function test_returnFormatedWebcamArray_getsArray_formatedItForView()
    {
        $expectedResult = [
            ['wbmerNick' => 'fake','wbmerThumb4' => '3d34412bed40ee22ab54781965e588ca.jpg','wbmerThumb2' => '3d34412bed40ee22ab54781965e588ca.jpg','size' => 'small'],
            ['wbmerNick' => 'fake','wbmerThumb4' => '3d34412bed40ee22ab54781965e588ca.jpg','wbmerThumb2' => '3d34412bed40ee22ab54781965e588ca.jpg','size' => 'small']
        ];
        $totalArray = [
            ['wbmerId' => '000','other'=> '111','wbmerNick' => 'fake','wbmerThumb4' => '3d34412bed40ee22ab54781965e588ca.jpg','wbmerThumb2' => '3d34412bed40ee22ab54781965e588ca.jpg','size' => 'small'],
            ['wbmerId' => '000','other'=> '111','wbmerNick' => 'fake','wbmerThumb4' => '3d34412bed40ee22ab54781965e588ca.jpg','wbmerThumb2' => '3d34412bed40ee22ab54781965e588ca.jpg','size' => 'small']
        ];
        $this->validatorStub->method('validationResult')->willReturn($totalArray);
        $repository = new WhiteLabelRepository($this->validatorStub,null);    
        $repository->reorderWebCamArrayFollowingPattern();
        $reorderResult = $repository->returnFormatedWebcamArray();
        $this->assertEquals($expectedResult[0],$reorderResult[0]);
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