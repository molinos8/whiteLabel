<?php

namespace Tests;


use App\BM\WhiteLabel;
use App\BM\Repositories\WhiteLabelRepository;
use app\BM\Wrappers\BMErrors;
use Illuminate\Foundation\Testing\TestCase;

class WhiteLabelTest extends TestCase
{
    /**
     * WhiteLabel Model ID.
     *
     * @var int
     */
    protected $BMId = '001';

    /**
     * Fake affiliate.
     *
     * @var string
     */
    protected $fakeAffiliate = 'fake';

    /**
     * Function to create laravel app.
     *
     * @return app
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../../../../bootstrap/app.php';

        $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    /**
     * WhiteLabelTest setup.
     *
     * @return void
     */
    public function setup(): void
    {
        parent::__construct();
        $this->createApplication();
        if (!$this->app) {
            $this->refreshApplication();
        }
        
        $this->whiteLabelRepositoryStub = $this->getMockBuilder(WhiteLabelRepository::class)->disableOriginalConstructor()->getMock();;
        $this->whiteLabelStub = $this->getMockBuilder(WhiteLabel::class)->disableOriginalConstructor()->getMock();     
        $this->whiteLabel = new WhiteLabel($this->whiteLabelRepositoryStub, $this->fakeAffiliate);
    }

    /**
     * Test that WhiteLabelClass Exists
     *
     * @return void
     */
    public function test_WhiteLabelClassExists(): void
    {
        $bm = $this->getMockBuilder(WhiteLabel::class)->disableOriginalConstructor()->getMockForAbstractClass();
        $this->assertInstanceOf(\App\BM\WhiteLabel ::class, $bm);
    }

    /**
     * Test method getId exist .
     *
     * @return void
     */
    public function test_getId_exist_effectivelyExists(): void
    {
        $this->assertTrue(
            method_exists($this->whiteLabelStub, 'getId'),
            'Class does not have method getId'
        );
    }

    /**
     * Test if method getId returns business model ID.
     *
     * @return void
     */   
    public function test_getId_returnsBMId_effectivelyReturnsIt():void
    {
        $this->whiteLabelStub->method('getId')->willReturn('001');
        $this->assertEquals($this->whiteLabelStub->getId(), $this->BMId);
    }

    /**
     * Test if generateThumbUrl get thumb url returns complete url
     *
     * @return void
     */   
    public function test_generateThumbUrl_getThumbUrl_returnsCompleteUrl():void
    {
        $fakeUrl = 'fake.jpg';
        $expectedUrl = config('config.webCamThumbImgUrl').$fakeUrl;
        $finalUrl = $this->whiteLabel->generateThumbUrl($fakeUrl);
        $this->assertEquals($finalUrl,$expectedUrl);
    }

    /**
     * Test if checkForValidJson gets BMerror return BMError
     *
     * @return void
     */  
    public function test_checkForValidJson_getsBMerror_returnBMError():void
    {
        $BMError = new BMErrors('fake','000','fake','fake',[],[]);
        $this->whiteLabelRepositoryStub->method('checkForValidatorBMErrors')->willReturn($BMError);
        $whiteLabel = new WhiteLabel($this->whiteLabelRepositoryStub,$this->fakeAffiliate);
        $this->assertInstanceOf(BMErrors::class,$whiteLabel->checkForValidJson());
    }

    /**
     * Test addUrlsToWebCamDataArray gets webCam data array, complete rrl and return completed array
     *
     * @return void
     */  
    public function test_addUrlsToWebCamDataArray_getsWebCamDataArrayComleteUrl_returnCompletedArray():void
    {
        $realAffiliates =  config('config.natsCode');
        $original = [
            ['wbmerNick' => 'fake','wbmerThumb4' => '3d34412bed40ee22ab54781965e588ca.jpg','wbmerThumb2' => '3d34412bed40ee22ab54781965e588ca.jpg','size' => 'small'],
            ['wbmerNick' => 'fake','wbmerThumb4' => '3d34412bed40ee22ab54781965e588ca.jpg','wbmerThumb2' => '3d34412bed40ee22ab54781965e588ca.jpg','size' => 'small']
        ];
        $expected = [
            ['wbmerNick' => 'fake', 'wbmerThumb4' => config('config.webCamThumbImgUrl').'3d34412bed40ee22ab54781965e588ca.jpg', 'wbmerThumb2' => config('config.webCamThumbImgUrl').'3d34412bed40ee22ab54781965e588ca.jpg', 'size' => 'small', 'wbmerLink' => config('config.webCamUrlBase').'fake/?nats='.$realAffiliates[array_key_first($realAffiliates)]],
            ['wbmerNick' => 'fake', 'wbmerThumb4' => config('config.webCamThumbImgUrl').'3d34412bed40ee22ab54781965e588ca.jpg', 'wbmerThumb2' => config('config.webCamThumbImgUrl').'3d34412bed40ee22ab54781965e588ca.jpg', 'size' => 'small', 'wbmerLink' => config('config.webCamUrlBase').'fake/?nats='.$realAffiliates[array_key_first($realAffiliates)]]
        ];
        $whiteLabel = $this->generateValidWhiteLabel();
        $whiteLabel->getNatCodeForAffiliate();
        $result = $whiteLabel->addUrlsToWebCamDataArray($original);
        $this->assertEquals($result,$expected);

    }

    /**
     * Test checkForValidJson gets valid json return true
     *
     * @return void
     */  
    public function test_checkForValidJson_getsValidJson_returnTrue():void
    {
        $fakeResult = false;
        $this->whiteLabelRepositoryStub->method('checkForValidatorBMErrors')->willReturn($fakeResult);
        $whiteLabel = new WhiteLabel($this->whiteLabelRepositoryStub,$this->fakeAffiliate);
        $this->assertTrue($whiteLabel->checkForValidJson());
    }

    /**
     * Test validateAffiliate gets wrong affiliate return BMError
     *
     * @return void
     */  
    public function test_validateAffiliate_getsWrongAffiliate_returnBMError():void
    {
        $fakeResult = false;
        $this->whiteLabelRepositoryStub->method('checkForValidatorBMErrors')->willReturn($fakeResult);
        $whiteLabel = new WhiteLabel($this->whiteLabelRepositoryStub,$this->fakeAffiliate);
        $result = $whiteLabel->validateAffiliate();
        $this->assertInstanceOf(BMErrors::class,$result);
    }

    /**
     * Test validateAffiliate gets right affiliate return true
     *
     * @return void
     */  
    public function test_validateAffiliate_getsRightAffiliate_returnTrue():void
    {
        $whiteLabel = $this->generateValidWhiteLabel();
        $result = $whiteLabel->validateAffiliate();
        $this->assertTrue($result);
    }

    /**
     * Test getNatCodeForAffiliate gets affiliate return Nats Code
     *
     * @return void
     */ 
    public function test_getNatCodeForAffiliate_getsAffiliate_returnNatsCode()
    {
        $realAffiliates =  config('config.natsCode');
        $expected = $realAffiliates[array_key_first($realAffiliates)];
        $whiteLabel = $this->generateValidWhiteLabel();
        $result = $whiteLabel->getNatCodeForAffiliate();
        $this->assertEquals($result,$expected);
    }

    /**
     * Test generateWebCamUrl gets  girl name return complete WebCam URL
     *
     * @return void
     */    
    public function test_generateWebCamUrl_getsGirlName_returnCompleteWebCamUrl()
    {
        $girlName = 'fake';
        $realAffiliates =  config('config.natsCode');
        $expectedResult = config('config.webCamUrlBase').$girlName.'/?nats='.$realAffiliates[array_key_first($realAffiliates)];
        $whiteLabel = $this->generateValidWhiteLabel();
        $whiteLabel->getNatCodeForAffiliate();
        $result = $whiteLabel->generateWebCamUrl($girlName);
        $this->assertEquals($result,$expectedResult);
    }

    /**
     * Test returnGoogleAnalitics get affiliate returns GA Code
     *
     * @return void
     */ 
    public function test_returnGoogleAnalitics_getAffiliate_returnsGACode()
    {
        $realAffiliates =  config('config.GACode');
        $expected = $realAffiliates[array_key_first($realAffiliates)];
        $whiteLabel = $this->generateValidWhiteLabel();
        $result = $whiteLabel->returnGoogleAnalitics();
        $this->assertEquals($result,$expected);
    }

    /**
     * Test returnAffiliateName get affiliate returns name
     *
     * @return void
     */ 
    public function test_returnAffiliateName_getAffiliate_returnsName()
    {
        $realAffiliates =  config('config.affiliateName');
        $expected = $realAffiliates[array_key_first($realAffiliates)];
        $whiteLabel = $this->generateValidWhiteLabel();
        $result = $whiteLabel->returnAffiliateName();
        $this->assertEquals($result,$expected);
    }
    /**
     * Generate a Valid white label class
     *
     * @return WhiteLabel valid object
     */  
    public function generateValidWhiteLabel():WhiteLabel
    {
        $fakeResult = false;
        $realAffiliates =  config('config.natsCode');
        $this->whiteLabelRepositoryStub->method('checkForValidatorBMErrors')->willReturn($fakeResult);
        $whiteLabel = new WhiteLabel($this->whiteLabelRepositoryStub,array_key_first($realAffiliates));
        
        return $whiteLabel;
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
