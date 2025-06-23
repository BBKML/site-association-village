<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\ImageService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ImageServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $imageService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->imageService = new ImageService();
        Storage::fake('public');
    }

    /** @test */
    public function it_can_generate_unique_filename()
    {
        $file = UploadedFile::fake()->image('test.jpg');
        
        $filename = $this->invokeMethod($this->imageService, 'generateFilename', [$file]);
        
        $this->assertStringContainsString('.jpg', $filename);
        $this->assertNotEquals('test.jpg', $filename);
    }

    /** @test */
    public function it_can_generate_size_filename()
    {
        $filename = 'test_123.jpg';
        $size = 'thumbnail';
        
        $sizeFilename = $this->invokeMethod($this->imageService, 'generateSizeFilename', [$filename, $size]);
        
        $this->assertEquals('test_123_thumbnail.jpg', $sizeFilename);
    }

    /** @test */
    public function it_returns_default_sizes()
    {
        $sizes = ImageService::getDefaultSizes();
        
        $this->assertArrayHasKey('thumbnail', $sizes);
        $this->assertArrayHasKey('small', $sizes);
        $this->assertArrayHasKey('medium', $sizes);
        $this->assertArrayHasKey('large', $sizes);
        
        $this->assertEquals(150, $sizes['thumbnail']['width']);
        $this->assertEquals(150, $sizes['thumbnail']['height']);
    }

    /** @test */
    public function it_can_optimize_and_save_image()
    {
        $file = UploadedFile::fake()->image('test.jpg', 1920, 1080);
        $path = 'test-images';
        $sizes = ['thumbnail' => ['width' => 150, 'height' => 150]];
        
        $result = $this->imageService->optimizeAndSave($file, $path, $sizes);
        
        $this->assertArrayHasKey('original', $result);
        $this->assertArrayHasKey('thumbnail', $result);
        
        // Vérifier que les fichiers existent
        $this->assertTrue(Storage::disk('public')->exists($result['original']));
        $this->assertTrue(Storage::disk('public')->exists($result['thumbnail']));
    }

    /** @test */
    public function it_can_delete_image_and_variants()
    {
        $file = UploadedFile::fake()->image('test.jpg');
        $path = 'test-images';
        $sizes = ['thumbnail' => ['width' => 150, 'height' => 150]];
        
        $result = $this->imageService->optimizeAndSave($file, $path, $sizes);
        
        // Supprimer l'image
        $this->imageService->deleteImage($result['original'], ['thumbnail']);
        
        // Vérifier que les fichiers ont été supprimés
        $this->assertFalse(Storage::disk('public')->exists($result['original']));
        $this->assertFalse(Storage::disk('public')->exists($result['thumbnail']));
    }

    /** @test */
    public function it_handles_missing_files_gracefully()
    {
        $path = 'non-existent-image.jpg';
        $sizes = ['thumbnail'];
        
        // Ne devrait pas lever d'exception
        $this->imageService->deleteImage($path, $sizes);
        
        $this->assertTrue(true); // Test réussi si aucune exception n'est levée
    }

    /**
     * Méthode utilitaire pour appeler des méthodes privées/protégées
     */
    protected function invokeMethod($object, $methodName, array $parameters = [])
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($object, $parameters);
    }
} 