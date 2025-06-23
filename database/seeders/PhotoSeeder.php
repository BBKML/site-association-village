<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Photo;
use App\Models\Gallery;

class PhotoSeeder extends Seeder
{
    public function run(): void
    {
        $galleries = Gallery::all();

        if ($galleries->count() > 0) {
            $photos = [
                [
                    'title' => 'Place du village',
                    'description' => 'Vue générale de la place centrale du village',
                    'gallery_id' => $galleries->random()->id,
                ],
                [
                    'title' => 'Église historique',
                    'description' => 'L\'église du village, monument historique',
                    'gallery_id' => $galleries->random()->id,
                ],
                [
                    'title' => 'Fête traditionnelle',
                    'description' => 'Célébration de la fête du village',
                    'gallery_id' => $galleries->random()->id,
                ],
                [
                    'title' => 'Artisanat local',
                    'description' => 'Travaux d\'artisanat traditionnel',
                    'gallery_id' => $galleries->random()->id,
                ],
                [
                    'title' => 'Paysage rural',
                    'description' => 'Vue sur les champs et la campagne environnante',
                    'gallery_id' => $galleries->random()->id,
                ],
            ];

            foreach ($photos as $photo) {
                Photo::create($photo);
            }
        }
    }
} 