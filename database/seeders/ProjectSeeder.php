<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'title' => 'Rénovation de la place centrale',
                'description' => 'Projet de rénovation complète de la place centrale du village avec installation de bancs, amélioration de l\'éclairage et création d\'espaces verts.',
                'start_date' => now()->addDays(30),
                'end_date' => now()->addMonths(6),
                'status' => 'planning',
                'budget' => 50000.00,
            ],
            [
                'title' => 'Création d\'une bibliothèque communale',
                'description' => 'Mise en place d\'une bibliothèque communale pour promouvoir la lecture et l\'éducation dans le village.',
                'start_date' => now()->addMonths(2),
                'end_date' => now()->addMonths(8),
                'status' => 'planning',
                'budget' => 25000.00,
            ],
            [
                'title' => 'Installation de panneaux solaires',
                'description' => 'Projet d\'installation de panneaux solaires sur les bâtiments communaux pour réduire les coûts énergétiques.',
                'start_date' => now()->subMonths(1),
                'end_date' => now()->addMonths(2),
                'status' => 'in_progress',
                'budget' => 35000.00,
            ],
            [
                'title' => 'Aménagement d\'un sentier pédestre',
                'description' => 'Création d\'un sentier pédestre autour du village pour promouvoir la randonnée et le tourisme local.',
                'start_date' => now()->subMonths(3),
                'end_date' => now()->addMonths(1),
                'status' => 'completed',
                'budget' => 15000.00,
            ],
        ];

        foreach ($projects as $project) {
            Project::create($project);
        }
    }
} 