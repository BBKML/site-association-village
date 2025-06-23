<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            GallerySeeder::class,
            ArticleSeeder::class,
            EventSeeder::class,
            PhotoSeeder::class,
            ProjectSeeder::class,
            ServiceSeeder::class,
            TeamSeeder::class,
            PageSeeder::class,
            SettingSeeder::class,
        ]);
    }
}
