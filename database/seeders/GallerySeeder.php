<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gallery;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $galleries = [
            [
                'file_path' => 'galleries/evenements-2024.jpg',
                'caption' => 'Photos des événements organisés en 2024',
                'date' => now(),
            ],
            [
                'file_path' => 'galleries/patrimoine.jpg',
                'caption' => 'Photos du patrimoine historique du village',
                'date' => now(),
            ],
            [
                'file_path' => 'galleries/activites.jpg',
                'caption' => 'Photos des activités quotidiennes de l\'association',
                'date' => now(),
            ],
            [
                'file_path' => 'galleries/projets.jpg',
                'caption' => 'Photos des projets réalisés par l\'association',
                'date' => now(),
            ],
        ];

        foreach ($galleries as $gallery) {
            Gallery::create($gallery);
        }
    }
} 