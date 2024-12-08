<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Solo312\Defer;

class DeferTest extends TestCase
{

 
    public function testDefer()
    {
       // Create a mock callable that will be tracked
       $executionFlag = false;

       $defer = new Defer();
       $defer->defer(function () use (&$executionFlag) {
           $executionFlag = true;
       });
   
       // Ensure the callback hasn't been executed yet
       $this->assertFalse($executionFlag);
   
       // Trigger the destructor
       unset($defer);
   
       // Ensure the callback was executed
       $this->assertTrue($executionFlag);
    }
    


    public function testInitCreatesDeferInstanceAndAddsCallback(): void
{
    // Variable to check if the callback was executed
    $executionFlag = false;

    // Create a Defer instance using the static init method
    $defer = Defer::init(function () use (&$executionFlag) {
        $executionFlag = true;
    });

    // Ensure the Defer instance was created
    $this->assertInstanceOf(Defer::class, $defer);

    // Ensure the callback hasn't been executed yet
    $this->assertFalse($executionFlag);

    // Trigger the destructor
    unset($defer);

    // Ensure the callback was executed
    $this->assertTrue($executionFlag);
}

}
