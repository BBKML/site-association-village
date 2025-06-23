<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        // Créer les catégories si elles n'existent pas
        $categories = [
            ['name' => 'Culture', 'description' => 'Articles sur la culture locale'],
            ['name' => 'Événements', 'description' => 'Événements du village'],
            ['name' => 'Développement', 'description' => 'Projets de développement'],
            ['name' => 'Patrimoine', 'description' => 'Patrimoine historique'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['name' => $category['name']], $category);
        }

        $admin = User::where('email', 'admin@village.fr')->first();

        $articles = [
            [
                'title' => 'Bienvenue sur le site de l\'Association du Village',
                'excerpt' => 'Nous sommes ravis de vous accueillir sur notre nouveau site web.',
                'content' => 'Nous sommes ravis de vous accueillir sur notre nouveau site web. Cette plateforme vous permettra de suivre toutes nos activités et de rester informé des événements de notre village. L\'association œuvre depuis de nombreuses années pour le développement de notre communauté et la préservation de notre patrimoine culturel.',
                'user_id' => $admin->id,
                'category_id' => 1,
                'published_at' => now(),
            ],
            [
                'title' => 'Fête du Village 2024',
                'excerpt' => 'La traditionnelle fête du village aura lieu le mois prochain.',
                'content' => 'La traditionnelle fête du village aura lieu le mois prochain. Venez nombreux pour célébrer notre communauté et partager des moments conviviaux. Au programme : animations culturelles, stands d\'artisanat local, dégustations de spécialités régionales et soirée dansante.',
                'user_id' => $admin->id,
                'category_id' => 2,
                'published_at' => now(),
            ],
            [
                'title' => 'Projet de rénovation de la place centrale',
                'excerpt' => 'Nous lançons un projet ambitieux pour rénover la place centrale du village.',
                'content' => 'Nous lançons un projet ambitieux pour rénover la place centrale du village. Ce projet vise à améliorer l\'espace public et à créer un lieu de rencontre pour tous. La rénovation comprendra l\'installation de bancs, l\'amélioration de l\'éclairage et la création d\'espaces verts.',
                'user_id' => $admin->id,
                'category_id' => 3,
                'published_at' => now(),
            ],
        ];

        foreach ($articles as $article) {
            Article::create($article);
        }
    }
} 