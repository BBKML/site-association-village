<?php

namespace Tests\Unit;

// Fake captcha_check for testing
if (!function_exists('captcha_check')) {
    function captcha_check($value) {
        return true;
    }
}

use Tests\TestCase;
use App\Services\ContactValidationService;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactValidationServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $validationService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->validationService = new ContactValidationService();
    }

    /** @test */
    public function it_validates_required_fields()
    {
        $request = new Request();
        
        $errors = $this->validationService->validateContact($request);
        
        $this->assertArrayHasKey('name', $errors);
        $this->assertArrayHasKey('email', $errors);
        $this->assertArrayHasKey('subject', $errors);
        $this->assertArrayHasKey('message', $errors);
    }

    /** @test */
    public function it_validates_email_format()
    {
        $request = new Request([
            'name' => 'Test User',
            'email' => 'invalid-email',
            'subject' => 'Test Subject',
            'message' => 'Test message content with enough characters to pass validation',
        ]);
        
        $errors = $this->validationService->validateContact($request);
        
        $this->assertArrayHasKey('email', $errors);
    }

    /** @test */
    public function it_validates_name_length()
    {
        $request = new Request([
            'name' => 'A', // Trop court
            'email' => 'test@example.com',
            'subject' => 'Test Subject',
            'message' => 'Test message content with enough characters to pass validation',
        ]);
        
        $errors = $this->validationService->validateContact($request);
        
        $this->assertArrayHasKey('name', $errors);
    }

    /** @test */
    public function it_validates_subject_length()
    {
        $request = new Request([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'subject' => 'Test', // Trop court
            'message' => 'Test message content with enough characters to pass validation',
        ]);
        
        $errors = $this->validationService->validateContact($request);
        
        $this->assertArrayHasKey('subject', $errors);
    }

    /** @test */
    public function it_validates_message_length()
    {
        $request = new Request([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'subject' => 'Test Subject',
            'message' => 'Short', // Trop court
        ]);
        
        $errors = $this->validationService->validateContact($request);
        
        $this->assertArrayHasKey('message', $errors);
    }

    /** @test */
    public function it_validates_phone_format()
    {
        $request = new Request([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => 'invalid-phone',
            'subject' => 'Test Subject',
            'message' => 'Test message content with enough characters to pass validation',
        ]);
        
        $errors = $this->validationService->validateContact($request);
        
        $this->assertArrayHasKey('phone', $errors);
    }

    /** @test */
    public function it_detects_spam_via_honeypot()
    {
        $request = new Request([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'subject' => 'Test Subject',
            'message' => 'Test message content with enough characters to pass validation',
            'website' => 'http://spam.com', // Champ honeypot rempli
        ]);
        
        $errors = $this->validationService->validateContact($request);
        
        $this->assertArrayHasKey('spam', $errors);
    }

    /** @test */
    public function it_detects_spam_keywords()
    {
        $request = new Request([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'subject' => 'Test Subject',
            'message' => 'Buy viagra now!',
        ]);
        
        $errors = $this->validationService->validateContact($request);
        
        $this->assertArrayHasKey('spam', $errors);
    }

    /** @test */
    public function it_detects_multiple_links()
    {
        $request = new Request([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'subject' => 'Test Subject',
            'message' => 'Check these links: http://link1.com http://link2.com http://link3.com',
        ]);
        
        $errors = $this->validationService->validateContact($request);
        
        $this->assertArrayHasKey('spam', $errors);
    }

    /** @test */
    public function it_accepts_valid_data()
    {
        $request = new \Illuminate\Http\Request([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '0123456789',
            'subject' => 'Test Subject',
            'message' => 'Test message content with enough characters to pass validation',
            'captcha' => 'dummy-value', // Champ non vide
        ]);
        
        $errors = $this->validationService->validateContact($request);
        
        $this->assertEmpty($errors);
    }

    /** @test */
    public function it_sanitizes_data()
    {
        $data = [
            'name' => '  Test User  ',
            'email' => '  TEST@EXAMPLE.COM  ',
            'phone' => '  0123456789  ',
            'subject' => '  <script>alert("xss")</script>Test Subject  ',
            'message' => '  <script>alert("xss")</script>Test message content  ',
        ];
        
        $cleanData = $this->validationService->sanitizeData($data);
        
        $this->assertEquals('Test User', $cleanData['name']);
        $this->assertEquals('test@example.com', $cleanData['email']);
        $this->assertEquals('0123456789', $cleanData['phone']);
        $this->assertEquals('alert("xss")Test Subject', $cleanData['subject']);
        $this->assertEquals('alert("xss")Test message content', $cleanData['message']);
    }
} 