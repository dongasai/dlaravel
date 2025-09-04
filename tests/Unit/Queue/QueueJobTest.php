<?php

namespace DLaravel\Tests\Unit\Queue;

use DLaravel\Tests\Unit\TestCase;

class QueueJobTest extends TestCase
{
    public function testQueueJobClassExists()
    {
        // 测试队列任务基类存在
        $this->assertTrue(class_exists(\DLaravel\Queue\QueueJob::class));
    }
    
    public function testShouldQueueClassExists()
    {
        // 测试队列事件监听器基类存在
        $this->assertTrue(class_exists(\DLaravel\Queue\ShouldQueue::class));
    }
}