<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use app\BM\Wrappers\BMErrors;
use App\BM\Validators\WhiteLabelJSONValidator;
use App\BM\Repositories\WhiteLabelRepository;
use App\BM\WhiteLabel;

/**
 *  WhiteLabel Controllers
 */
class WhiteLavelController extends Controller
{
    /**
     *  Function show catch request host to send for WhiteLabel BM to generate array data for view
     * 
     * @return view view of white label.
     */ 
    public function show()
    {

        $affiliateHost = request()->getHost();
        $whiteLabelRepositoryValidator = new WhiteLabelJSONValidator();
        $whiteLabelRepository = new WhiteLabelRepository($whiteLabelRepositoryValidator);
        $whiteLabel = new WhiteLabel($whiteLabelRepository,$affiliateHost);
        if($whiteLabel->returnWebCamsValues() instanceof BMErrors) {
            //in this place we must persist or show the error.
        }  
        $whiteLabelName = $whiteLabel->returnAffiliateName();
        $webCamsData = $whiteLabel->returnWebCamsValues();
        $affiliateGA = $whiteLabel->returnGoogleAnalitics();
        return view('whiteLabel', ['webCamsData' => $webCamsData, 'name' => $whiteLabelName, 'affiliateGA' => $affiliateGA]);
    }
}