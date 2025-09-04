<?php

namespace DLaravel\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        
        // 设置测试环境
        putenv('APP_ENV=testing');
        putenv('APP_DEBUG=true');
    }
    
    protected function tearDown(): void
    {
        parent::tearDown();
        
        // 清理测试环境
        putenv('APP_ENV');
        putenv('APP_DEBUG');
    }
}