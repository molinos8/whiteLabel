<?php

namespace Tests;


use App\Http\Controllers\WhiteLabelController;

use PHPUnit\Framework\TestCase;

class WhiteLabelControllerTest extends TestCase
{
    /**
     * Test that WhiteLabelControllerClass Exists
     *
     * @return void
     */
    public function test_WhiteLabelControllerClassExists()
    {
        $controller = $this->getMockBuilder(\App\Http\Controllers\WhiteLavelController::class)->disableOriginalConstructor()->getMockForAbstractClass();
        $this->assertInstanceOf(\App\Http\Controllers\WhiteLavelController ::class, $controller);
    }

    
}
