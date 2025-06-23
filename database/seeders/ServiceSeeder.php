<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'name' => 'Épicerie du Village',
                'description' => 'Épicerie générale proposant des produits locaux et de première nécessité. Ouverte tous les jours de 7h à 19h.',
                'price' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Atelier de Poterie',
                'description' => 'Fabrication de poteries traditionnelles et cours d\'initiation pour tous les âges. Découvrez l\'art de la céramique locale.',
                'price' => 25.00,
                'is_active' => true,
            ],
            [
                'name' => 'Dispensaire',
                'description' => 'Soins de santé primaires et consultations médicales. Ouvert du lundi au vendredi de 8h à 17h.',
                'price' => 5.00,
                'is_active' => true,
            ],
            [
                'name' => 'Café-Restaurant',
                'description' => 'Restaurant traditionnel proposant des spécialités locales et des plats du jour. Réservation recommandée.',
                'price' => 15.00,
                'is_active' => true,
            ],
            [
                'name' => 'Location de salles',
                'description' => 'Location de salles pour événements privés, réunions et célébrations. Capacité jusqu\'à 50 personnes.',
                'price' => 100.00,
                'is_active' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
} 