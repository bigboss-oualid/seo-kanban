<?php

namespace App\Tests\phpunit;


use App\App;
use App\Model\Board;
use PHPUnit\Framework\TestCase;
use System\Application;
use System\File;

class AppTest extends TestCase
{
    public function testBoard(): void {
        $board = new Board(['name' =>'test']);
        $this->assertSame( $board->getName(), 'test');
        $board->setName('test2');
        $this->assertSame( $board->getName(), 'test2');
    }
    /*public function testApp(): void {
        $file = new File(dirname(__DIR__,2));
        $app =  Application::getInstance($file);

        //$app->run();
    }*/
}