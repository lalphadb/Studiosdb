<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ConsentType;

class ConsentTypeSeeder extends Seeder
{
    public function run()
    {
        $types = [
            [
                'key' => 'terms_conditions',
                'name' => 'Conditions d\'utilisation',
                'description' => 'J\'accepte les conditions d\'utilisation du service',
                'is_required' => true,
            ],
            [
                'key' => 'privacy_policy',
                'name' => 'Politique de confidentialité',
                'description' => 'J\'ai lu et j\'accepte la politique de confidentialité',
                'is_required' => true,
            ],
            [
                'key' => 'marketing_emails',
                'name' => 'Communications marketing',
                'description' => 'J\'accepte de recevoir des communications marketing par courriel',
                'is_required' => false,
            ],
            [
                'key' => 'photo_usage',
                'name' => 'Utilisation de photos',
                'description' => 'J\'autorise l\'utilisation de mes photos à des fins promotionnelles',
                'is_required' => false,
            ],
            [
                'key' => 'emergency_contact',
                'name' => 'Contact d\'urgence',
                'description' => 'J\'autorise le partage de mes informations avec les contacts d\'urgence',
                'is_required' => false,
            ],
            [
                'key' => 'cookies_analytics',
                'name' => 'Cookies analytiques',
                'description' => 'J\'accepte l\'utilisation de cookies à des fins analytiques',
                'is_required' => false,
            ],
        ];
        
        foreach ($types as $type) {
            ConsentType::updateOrCreate(['key' => $type['key']], $type);
        }
    }
}
