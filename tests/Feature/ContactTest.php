<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Contact;
use App\Services\ContactValidationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class ContactTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function it_can_display_contact_page()
    {
        $response = $this->get('/contact');

        $response->assertStatus(200);
        $response->assertViewIs('frontend.contact');
    }

    /** @test */
    public function it_validates_required_fields()
    {
        $response = $this->post('/contact', []);

        $response->assertSessionHasErrors(['name', 'email', 'subject', 'message']);
    }

    /** @test */
    public function it_validates_email_format()
    {
        $response = $this->post('/contact', [
            'name' => 'Test User',
            'email' => 'invalid-email',
            'subject' => 'Test Subject',
            'message' => 'Test message content with enough characters to pass validation',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function it_validates_name_length()
    {
        $response = $this->post('/contact', [
            'name' => 'A', // Trop court
            'email' => 'test@example.com',
            'subject' => 'Test Subject',
            'message' => 'Test message content with enough characters to pass validation',
        ]);

        $response->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function it_validates_subject_length()
    {
        $response = $this->post('/contact', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'subject' => 'Test', // Trop court
            'message' => 'Test message content with enough characters to pass validation',
        ]);

        $response->assertSessionHasErrors(['subject']);
    }

    /** @test */
    public function it_validates_message_length()
    {
        $response = $this->post('/contact', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'subject' => 'Test Subject',
            'message' => 'Short', // Trop court
        ]);

        $response->assertSessionHasErrors(['message']);
    }

    /** @test */
    public function it_validates_phone_format()
    {
        $response = $this->post('/contact', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => 'invalid-phone',
            'subject' => 'Test Subject',
            'message' => 'Test message content with enough characters to pass validation',
        ]);

        $response->assertSessionHasErrors(['phone']);
    }

    /** @test */
    public function it_accepts_valid_phone_formats()
    {
        $validPhones = [
            '0123456789',
            '+33123456789',
            '01 23 45 67 89',
            '(01) 23-45-67-89'
        ];

        foreach ($validPhones as $phone) {
            $response = $this->post('/contact', [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'phone' => $phone,
                'subject' => 'Test Subject',
                'message' => 'Test message content with enough characters to pass validation',
            ]);

            // Le téléphone ne devrait pas causer d'erreur de validation
            $this->assertFalse($response->session()->hasErrors('phone'));
        }
    }

    /** @test */
    public function it_detects_spam_via_honeypot()
    {
        $response = $this->post('/contact', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'subject' => 'Test Subject',
            'message' => 'Test message content with enough characters to pass validation',
            'website' => 'http://spam.com', // Champ honeypot rempli
        ]);

        $response->assertSessionHasErrors(['spam']);
    }

    /** @test */
    public function it_detects_spam_keywords()
    {
        $spamMessages = [
            'Buy viagra now!',
            'Make money fast with our casino',
            'Free loan application',
            'Click here to win money'
        ];

        foreach ($spamMessages as $message) {
            $response = $this->post('/contact', [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'subject' => 'Test Subject',
                'message' => $message,
            ]);

            $response->assertSessionHasErrors(['spam']);
        }
    }

    /** @test */
    public function it_detects_multiple_links()
    {
        $response = $this->post('/contact', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'subject' => 'Test Subject',
            'message' => 'Check these links: http://link1.com http://link2.com http://link3.com',
        ]);

        $response->assertSessionHasErrors(['spam']);
    }

    /** @test */
    public function it_validates_submission_speed()
    {
        // Première soumission
        $this->post('/contact', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'subject' => 'Test Subject',
            'message' => 'Test message content with enough characters to pass validation',
        ]);

        // Deuxième soumission immédiate
        $response = $this->post('/contact', [
            'name' => 'Test User 2',
            'email' => 'test2@example.com',
            'subject' => 'Test Subject 2',
            'message' => 'Test message content 2 with enough characters to pass validation',
        ]);

        $response->assertSessionHasErrors(['speed']);
    }

    /** @test */
    public function it_creates_contact_with_valid_data()
    {
        $contactData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '0123456789',
            'subject' => 'Test Subject',
            'message' => 'Test message content with enough characters to pass validation',
        ];

        $response = $this->post('/contact', $contactData);

        $this->assertDatabaseHas('contacts', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '0123456789',
            'subject' => 'Test Subject',
            'message' => 'Test message content with enough characters to pass validation'
        ]);
    }

    /** @test */
    public function it_sanitizes_input_data()
    {
        $contactData = [
            'name' => '  Test User  ',
            'email' => '  TEST@EXAMPLE.COM  ',
            'phone' => '  0123456789  ',
            'subject' => '  <script>alert("xss")</script>Test Subject  ',
            'message' => '  <script>alert("xss")</script>Test message content  ',
        ];

        $this->post('/contact', $contactData);

        $this->assertDatabaseHas('contacts', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '0123456789',
            'subject' => 'Test Subject',
            'message' => 'Test message content'
        ]);
    }

    /** @test */
    public function it_logs_contact_creation()
    {
        $contactData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '0123456789',
            'subject' => 'Test Subject',
            'message' => 'Test message content with enough characters to pass validation',
        ];

        $this->post('/contact', $contactData);

        // Vérifier que le contact a été créé avec les métadonnées
        $contact = Contact::where('email', 'test@example.com')->first();

        $this->assertNotNull($contact);
        $this->assertNotNull($contact->ip_address);
        $this->assertNotNull($contact->user_agent);
        $this->assertFalse($contact->is_read);
    }
} 