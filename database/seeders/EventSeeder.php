<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            [
                'title' => 'Assemblée Générale',
                'description' => 'Assemblée générale annuelle de l\'association pour présenter les projets de l\'année et élire le nouveau bureau.',
                'date' => now()->addDays(30),
                'location' => 'Salle communale',
            ],
            [
                'title' => 'Fête du Village',
                'description' => 'Grande fête traditionnelle avec animations, musique traditionnelle, stands d\'artisanat et restauration locale.',
                'date' => now()->addDays(60),
                'location' => 'Place centrale',
            ],
            [
                'title' => 'Atelier Artisanat',
                'description' => 'Découverte des métiers traditionnels et initiation aux techniques artisanales locales. Ouvert à tous les âges.',
                'date' => now()->addDays(15),
                'location' => 'Maison des associations',
            ],
            [
                'title' => 'Exposition Photos',
                'description' => 'Exposition de photos historiques du village et présentation de l\'évolution de notre communauté.',
                'date' => now()->addDays(45),
                'location' => 'Mairie',
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
} 