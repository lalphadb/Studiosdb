<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Ecole;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Super Admin
        $superadmin = User::create([
            'name' => 'Super Admin',
            'email' => 'lalpha@4lb.ca',
            'username' => 'superadmin',
            'password' => Hash::make('QwerTfc443-studios!'),
            'role' => 'superadmin',
            'active' => 1,
            'email_verified_at' => now()
        ]);
        $superadmin->assignRole('superadmin');

        // Admins par école
        $ecoles = Ecole::all();
        
        foreach ($ecoles as $index => $ecole) {
            $admin = User::create([
                'name' => "Admin {$ecole->nom}",
                'email' => "admin.{$index}@4lb.ca",
                'username' => "admin_ecole_{$ecole->id}",
                'password' => Hash::make('Bobby2111'),
                'role' => 'admin',
                'ecole_id' => $ecole->id,
                'active' => 1,
                'email_verified_at' => now()
            ]);
            $admin->assignRole('admin');
        }

        echo "✅ Utilisateurs créés avec succès!\n";
    }
}
