<?php

namespace DLaravel\Tests\Unit\Validation;

use DLaravel\Tests\Unit\TestCase;
use DLaravel\ValidationCore;

class ValidationCoreTest extends TestCase
{
    private $validation;
    
    protected function setUp(): void
    {
        parent::setUp();
        
        // 创建一个测试用的验证类
        $this->validation = new class extends ValidationCore {
            public function rules(): array
            {
                return [
                    'name' => 'required|string|max:255',
                    'email' => 'required|email',
                ];
            }
            
            public function messages(): array
            {
                return [
                    'name.required' => '姓名不能为空',
                    'email.email' => '邮箱格式不正确',
                ];
            }
        };
    }
    
    public function testValidationRules()
    {
        $rules = $this->validation->rules();
        
        $this->assertIsArray($rules);
        $this->assertArrayHasKey('name', $rules);
        $this->assertArrayHasKey('email', $rules);
    }
    
    public function testValidationMessages()
    {
        $messages = $this->validation->messages();
        
        $this->assertIsArray($messages);
        $this->assertArrayHasKey('name.required', $messages);
        $this->assertArrayHasKey('email.email', $messages);
    }
    
    public function testDefaultMethod()
    {
        $default = $this->validation->default();
        
        $this->assertIsArray($default);
    }
}