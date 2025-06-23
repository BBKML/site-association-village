<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'site_name', 'value' => 'Association du Village'],
            ['key' => 'site_description', 'value' => 'Développement communautaire et préservation du patrimoine local'],
            ['key' => 'contact_email', 'value' => 'contact@association-village.ci'],
            ['key' => 'contact_phone', 'value' => '+225 27 22 49 74 84'],
            ['key' => 'address', 'value' => '123 Rue du Village, 12345 Nom du Village, Côte d\'Ivoire'],
            ['key' => 'facebook_url', 'value' => 'https://facebook.com/association-village'],
            ['key' => 'twitter_url', 'value' => 'https://twitter.com/association-village'],
            ['key' => 'instagram_url', 'value' => 'https://instagram.com/association-village'],
            ['key' => 'youtube_url', 'value' => 'https://youtube.com/association-village'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value']]
            );
        }
    }
} 