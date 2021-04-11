<?php

namespace App\Tests\phpunit;


use App\App;
use PHPUnit\Framework\TestCase;

class AppTest extends TestCase
{
    public function testPrintHelloWorld(): void {
        $actualClass = new App();
        $this->assertEquals('Hello World', $actualClass->printHelloWorld());
    }
}