<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ImageService
{
    protected $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }

    /**
     * Optimise et sauvegarde une image
     */
    public function optimizeAndSave(UploadedFile $file, string $path, array $sizes = []): array
    {
        $filename = $this->generateFilename($file);
        $results = [];

        // Image originale optimisée
        $originalPath = $path . '/' . $filename;
        $this->optimizeImage($file, $originalPath);
        $results['original'] = $originalPath;

        // Images redimensionnées
        foreach ($sizes as $size => $dimensions) {
            $sizeFilename = $this->generateSizeFilename($filename, $size);
            $sizePath = $path . '/' . $size . '/' . $sizeFilename;
            
            $this->resizeAndSave($file, $sizePath, $dimensions['width'], $dimensions['height']);
            $results[$size] = $sizePath;
        }

        return $results;
    }

    /**
     * Optimise une image sans redimensionnement
     */
    protected function optimizeImage(UploadedFile $file, string $path): void
    {
        $image = $this->manager->read($file->getPathname());
        
        // Optimisation de la qualité
        $image->scaleDown(1920, 1080); // Taille maximale
        
        Storage::disk('public')->put($path, $image->toJpeg(85));
    }

    /**
     * Redimensionne et sauvegarde une image
     */
    protected function resizeAndSave(UploadedFile $file, string $path, int $width, int $height): void
    {
        $image = $this->manager->read($file->getPathname());
        
        // Redimensionnement avec crop intelligent
        $image->cover($width, $height);
        
        Storage::disk('public')->put($path, $image->toJpeg(85));
    }

    /**
     * Génère un nom de fichier unique
     */
    protected function generateFilename(UploadedFile $file): string
    {
        $extension = $file->getClientOriginalExtension();
        return uniqid() . '_' . time() . '.' . $extension;
    }

    /**
     * Génère un nom de fichier pour une taille spécifique
     */
    protected function generateSizeFilename(string $filename, string $size): string
    {
        $parts = explode('.', $filename);
        $extension = array_pop($parts);
        return implode('.', $parts) . '_' . $size . '.' . $extension;
    }

    /**
     * Supprime une image et ses variantes
     */
    public function deleteImage(string $path, array $sizes = []): void
    {
        // Supprime l'image originale
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        // Supprime les variantes
        foreach ($sizes as $size) {
            $sizePath = $this->getSizePath($path, $size);
            if (Storage::disk('public')->exists($sizePath)) {
                Storage::disk('public')->delete($sizePath);
            }
        }
    }

    /**
     * Obtient le chemin d'une variante de taille
     */
    protected function getSizePath(string $originalPath, string $size): string
    {
        $parts = explode('/', $originalPath);
        $filename = array_pop($parts);
        $sizeFilename = $this->generateSizeFilename($filename, $size);
        
        return implode('/', $parts) . '/' . $size . '/' . $sizeFilename;
    }

    /**
     * Tailles prédéfinies pour différents usages
     */
    public static function getDefaultSizes(): array
    {
        return [
            'thumbnail' => ['width' => 150, 'height' => 150],
            'small' => ['width' => 300, 'height' => 200],
            'medium' => ['width' => 600, 'height' => 400],
            'large' => ['width' => 1200, 'height' => 800],
        ];
    }
} 