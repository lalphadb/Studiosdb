<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ecole;

class EcoleSeeder extends Seeder
{
    public function run()
    {
        $ecoles = [
            // Écoles avec informations complètes
            [
                'nom' => 'Studios Unis Ancienne-Lorette',
                'adresse' => '7050 boul. Hamel Ouest, suite 80',
                'ville' => 'Ancienne-Lorette',
                'province' => 'Québec',
                'code_postal' => 'G2G 1B5',
                'telephone' => null,
                'email' => 'ancienne-lorette@studiosunis.com',
                'statut' => 'active'
            ],
            [
                'nom' => 'Studios Unis Beauce',
                'adresse' => '17118 boul. Lacroix, Suite 2',
                'ville' => 'St-Georges-de-Beauce',
                'province' => 'Québec',
                'code_postal' => 'G5Y 8G9',
                'telephone' => null,
                'email' => 'beauce@studiosunis.com',
                'statut' => 'active'
            ],
            [
                'nom' => 'Studios Unis Beauport',
                'adresse' => '2204 boul. Louis-XIV',
                'ville' => 'Beauport',
                'province' => 'Québec',
                'code_postal' => 'G1C 1A2',
                'telephone' => '(418) 667-7541',
                'email' => 'beauport@studiosunis.com',
                'statut' => 'active'
            ],
            [
                'nom' => 'Studios Unis Charlesbourg',
                'adresse' => '13061 boul. Henri-Bourassa',
                'ville' => 'Charlesbourg',
                'province' => 'Québec',
                'code_postal' => 'G1G 3Y6',
                'telephone' => '(418) 622-0822',
                'email' => 'charlesbourg@studiosunis.com',
                'statut' => 'active'
            ],
            [
                'nom' => 'Studios Unis Chicoutimi',
                'adresse' => '605 rue St-Paul',
                'ville' => 'Chicoutimi',
                'province' => 'Québec',
                'code_postal' => 'G7J 3Z4',
                'telephone' => '(418) 376-6357',
                'email' => 'chicoutimi@studiosunis.com',
                'statut' => 'active'
            ],
            [
                'nom' => 'Studios Unis Côte-de-Beaupré',
                'adresse' => '6218 boul. Sainte-Anne, suite 102',
                'ville' => 'L\'Ange-Gardien',
                'province' => 'Québec',
                'code_postal' => 'G0A 2K0',
                'telephone' => null,
                'email' => 'cote-de-beaupre@studiosunis.com',
                'statut' => 'active'
            ],
            [
                'nom' => 'Studios Unis Dolbeau-Mistassini',
                'adresse' => '1350 boul. Wallberg',
                'ville' => 'Dolbeau-Mistassini',
                'province' => 'Québec',
                'code_postal' => 'G8L 1H1',
                'telephone' => '(418) 618-0829',
                'email' => 'dolbeau@studiosunis.com',
                'statut' => 'active'
            ],
            [
                'nom' => 'Studios Unis Donnacona',
                'adresse' => '120 Armand Bombardier, local 260',
                'ville' => 'Donnacona',
                'province' => 'Québec',
                'code_postal' => 'G3M 1V3',
                'telephone' => null,
                'email' => 'donnacona@studiosunis.com',
                'statut' => 'active'
            ],
            [
                'nom' => 'Studios Unis Duberger',
                'adresse' => '2300 Père-Lelièvre',
                'ville' => 'Québec',
                'province' => 'Québec',
                'code_postal' => 'G1P 2X5',
                'telephone' => '(418) 683-8499',
                'email' => 'duberger@studiosunis.com',
                'statut' => 'active'
            ],
            [
                'nom' => 'Studios Unis Lac St-Charles',
                'adresse' => '876 rue Jacques Bédard',
                'ville' => 'Lac St-Charles',
                'province' => 'Québec',
                'code_postal' => 'G2N 1E3',
                'telephone' => null,
                'email' => 'lac-st-charles@studiosunis.com',
                'statut' => 'active'
            ],
            [
                'nom' => 'Studios Unis Laval-Ouest',
                'adresse' => '4610 boul. Arthur-Sauvé',
                'ville' => 'Laval',
                'province' => 'Québec',
                'code_postal' => 'H7R 3X1',
                'telephone' => null,
                'email' => 'laval-ouest@studiosunis.com',
                'statut' => 'active'
            ],
            [
                'nom' => 'Studios Unis Lévis',
                'adresse' => '40 route du Président-Kennedy #102',
                'ville' => 'Lévis',
                'province' => 'Québec',
                'code_postal' => 'G6V 6C4',
                'telephone' => null,
                'email' => 'levis@studiosunis.com',
                'statut' => 'active'
            ],
            [
                'nom' => 'Studios Unis Montmagny',
                'adresse' => '111 7e Rue',
                'ville' => 'Montmagny',
                'province' => 'Québec',
                'code_postal' => 'G5V 3H2',
                'telephone' => null,
                'email' => 'montmagny@studiosunis.com',
                'statut' => 'active'
            ],
            [
                'nom' => 'Studios Unis St-Étienne-de-Lauzon',
                'adresse' => '2760 route Lagueux',
                'ville' => 'Saint-Étienne-de-Lauzon',
                'province' => 'Québec',
                'code_postal' => 'G6J 1A2',
                'telephone' => null,
                'email' => 'st-etienne@studiosunis.com',
                'statut' => 'active'
            ],
            [
                'nom' => 'Studios Unis St-Jean-Chrysostome',
                'adresse' => '732 avenue Taniata',
                'ville' => 'Saint-Jean-Chrysostome',
                'province' => 'Québec',
                'code_postal' => 'G6Z 2C5',
                'telephone' => null,
                'email' => 'st-jean-chrysostome@studiosunis.com',
                'statut' => 'active'
            ],
            // Écoles avec informations incomplètes (à compléter)
            [
                'nom' => 'Studios Unis Québec',
                'adresse' => null,
                'ville' => 'Québec',
                'province' => 'Québec',
                'code_postal' => null,
                'telephone' => null,
                'email' => 'quebec@studiosunis.com',
                'statut' => 'active'
            ],
            [
                'nom' => 'Studios Unis St-Émile',
                'adresse' => null,
                'ville' => 'St-Émile',
                'province' => 'Québec',
                'code_postal' => null,
                'telephone' => null,
                'email' => 'st-emile@studiosunis.com',
                'statut' => 'active'
            ],
            [
                'nom' => 'Studios Unis St-Jérôme',
                'adresse' => null,
                'ville' => 'St-Jérôme',
                'province' => 'Québec',
                'code_postal' => null,
                'telephone' => null,
                'email' => 'st-jerome@studiosunis.com',
                'statut' => 'active'
            ],
            [
                'nom' => 'Studios Unis St-Nicolas',
                'adresse' => null,
                'ville' => 'St-Nicolas',
                'province' => 'Québec',
                'code_postal' => null,
                'telephone' => null,
                'email' => 'st-nicolas@studiosunis.com',
                'statut' => 'active'
            ],
            [
                'nom' => 'Studios Unis St-Urbain',
                'adresse' => null,
                'ville' => 'St-Urbain',
                'province' => 'Québec',
                'code_postal' => null,
                'telephone' => null,
                'email' => 'st-urbain@studiosunis.com',
                'statut' => 'active'
            ],
            [
                'nom' => 'Studios Unis Ste-Foy',
                'adresse' => null,
                'ville' => 'Ste-Foy',
                'province' => 'Québec',
                'code_postal' => null,
                'telephone' => null,
                'email' => 'ste-foy@studiosunis.com',
                'statut' => 'active'
            ],
            [
                'nom' => 'Studios Unis Val-Bélair',
                'adresse' => null,
                'ville' => 'Val-Bélair',
                'province' => 'Québec',
                'code_postal' => null,
                'telephone' => null,
                'email' => 'val-belair@studiosunis.com',
                'statut' => 'active'
            ]
        ];

        foreach ($ecoles as $ecole) {
            Ecole::create($ecole);
        }

        echo "✅ 22 écoles Studios Unis créées avec succès!\n";
    }
}
