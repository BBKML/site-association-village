<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Team;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
        $teams = [
            [
                'name' => 'Jean Dupont',
                'position' => 'Président',
                'bio' => 'Président de l\'association depuis 2020, Jean Dupont œuvre pour le développement communautaire et la préservation du patrimoine local.',
                'email' => 'jean.dupont@association-village.ci',
                'phone' => '+225 27 22 49 74 84',
                'is_active' => true,
            ],
            [
                'name' => 'Marie Martin',
                'position' => 'Secrétaire Générale',
                'bio' => 'Secrétaire générale de l\'association, Marie Martin coordonne les activités et assure la communication avec les membres.',
                'email' => 'marie.martin@association-village.ci',
                'phone' => '+225 27 22 49 74 85',
                'is_active' => true,
            ],
            [
                'name' => 'Pierre Durand',
                'position' => 'Trésorier',
                'bio' => 'Trésorier responsable des finances de l\'association et de la gestion budgétaire des projets.',
                'email' => 'pierre.durand@association-village.ci',
                'phone' => '+225 27 22 49 74 86',
                'is_active' => true,
            ],
            [
                'name' => 'Sophie Bernard',
                'position' => 'Responsable Culture',
                'bio' => 'Responsable des activités culturelles et de la préservation du patrimoine immatériel du village.',
                'email' => 'sophie.bernard@association-village.ci',
                'phone' => '+225 27 22 49 74 87',
                'is_active' => true,
            ],
            [
                'name' => 'Michel Leroy',
                'position' => 'Responsable Projets',
                'bio' => 'Coordinateur des projets de développement et de rénovation dans le village.',
                'email' => 'michel.leroy@association-village.ci',
                'phone' => '+225 27 22 49 74 88',
                'is_active' => true,
            ],
        ];

        foreach ($teams as $team) {
            Team::create($team);
        }
    }
} 