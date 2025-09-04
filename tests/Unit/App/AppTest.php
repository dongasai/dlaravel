<?php

namespace DLaravel\Tests\Unit\App;

use DLaravel\Tests\Unit\TestCase;
use DLaravel\App;

class AppTest extends TestCase
{
    public function testIsDebug()
    {
        // 测试调试模式检查
        $this->assertIsBool(App::is_debug());
    }
    
    public function testIsLocal()
    {
        // 测试本地环境检查
        $this->assertIsBool(App::is_local());
    }
    
    public function testAppClassExists()
    {
        // 测试App类存在
        $this->assertTrue(class_exists(App::class));
    }
}