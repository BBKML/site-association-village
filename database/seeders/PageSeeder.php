<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'title' => 'À Propos',
                'slug' => 'a-propos',
                'content' => '<h2>Notre Association</h2><p>L\'Association du Village œuvre depuis de nombreuses années pour le développement communautaire et la préservation du patrimoine local. Notre mission est de promouvoir la cohésion sociale, de préserver notre héritage culturel et de contribuer au développement durable de notre village.</p><h3>Nos Valeurs</h3><ul><li>Solidarité et entraide</li><li>Préservation du patrimoine</li><li>Développement durable</li><li>Inclusion sociale</li></ul>',
                'meta_description' => 'Découvrez l\'histoire et les missions de l\'Association du Village, dédiée au développement communautaire et à la préservation du patrimoine.',
                'is_published' => true,
            ],
            [
                'title' => 'Histoire du Village',
                'slug' => 'histoire',
                'content' => '<h2>L\'Histoire de Notre Village</h2><p>Notre village possède une histoire riche et passionnante qui remonte à plusieurs siècles. Fondé à l\'époque médiévale, il a traversé les époques en conservant son authenticité et son charme.</p><h3>Les Origines</h3><p>Les premières traces d\'occupation humaine remontent au XIIe siècle. Le village s\'est développé autour de son église et de sa place centrale, qui reste aujourd\'hui le cœur de notre communauté.</p><h3>L\'Époque Moderne</h3><p>Au fil des siècles, le village a su s\'adapter aux évolutions tout en préservant son identité. L\'agriculture traditionnelle côtoie aujourd\'hui les activités modernes.</p>',
                'meta_description' => 'Plongez dans l\'histoire fascinante de notre village, de ses origines médiévales à nos jours.',
                'is_published' => true,
            ],
            [
                'title' => 'Nos Objectifs',
                'slug' => 'objectifs',
                'content' => '<h2>Nos Objectifs</h2><p>L\'Association du Village poursuit plusieurs objectifs ambitieux pour le développement de notre communauté.</p><h3>Développement Durable</h3><p>Nous nous engageons pour un développement respectueux de l\'environnement et des générations futures. Nos projets intègrent systématiquement des considérations écologiques.</p><h3>Préservation Culturelle</h3><p>La sauvegarde de notre patrimoine culturel et historique est au cœur de nos préoccupations. Nous organisons régulièrement des événements pour transmettre notre héritage.</p><h3>Cohésion Sociale</h3><p>Nous favorisons les rencontres et les échanges entre les habitants pour renforcer les liens sociaux et créer une communauté soudée.</p>',
                'meta_description' => 'Découvrez les objectifs de l\'Association du Village : développement durable, préservation culturelle et cohésion sociale.',
                'is_published' => true,
            ],
            [
                'title' => 'Contact',
                'slug' => 'contact',
                'content' => '<h2>Nous Contacter</h2><p>L\'équipe de l\'Association du Village est à votre disposition pour répondre à vos questions et vous accueillir.</p><h3>Adresse</h3><p>123 Rue du Village<br>12345 Nom du Village<br>Côte d\'Ivoire</p><h3>Horaires d\'ouverture</h3><p>Lundi à Vendredi : 9h - 17h<br>Samedi : 9h - 12h<br>Dimanche : Fermé</p>',
                'meta_description' => 'Contactez l\'Association du Village. Nous sommes à votre disposition pour répondre à vos questions.',
                'is_published' => true,
            ],
        ];

        foreach ($pages as $page) {
            Page::create($page);
        }
    }
} 