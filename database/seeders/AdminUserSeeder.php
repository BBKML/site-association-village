<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Créer le rôle admin s'il n'existe pas
        $adminRole = Role::firstOrCreate(
            ['name' => 'admin'],
            ['description' => 'Administrateur du site']
        );

        // Créer l'utilisateur admin s'il n'existe pas
        User::firstOrCreate(
            ['email' => 'admin@village.fr'],
            [
                'name' => 'Administrateur',
                'password' => bcrypt('admin123'),
                'role_id' => $adminRole->id,
            ]
        );

        $this->command->info('Utilisateur administrateur créé avec succès !');
        $this->command->info('Email: admin@village.fr');
        $this->command->info('Mot de passe: admin123');
    }
} 