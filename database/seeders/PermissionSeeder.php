<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Permissions par module
        $permissions = [
            // Dashboard
            'view-dashboard',
            'view-superadmin-dashboard',
            
            // Écoles
            'view-ecoles',
            'create-ecoles',
            'edit-ecoles',
            'delete-ecoles',
            
            // Membres
            'view-membres',
            'create-membres',
            'edit-membres',
            'delete-membres',
            'approve-membres',
            
            // Cours
            'view-cours',
            'create-cours',
            'edit-cours',
            'delete-cours',
            'duplicate-cours',
            
            // Présences
            'view-presences',
            'take-presences',
            'edit-presences',
            
            // Inscriptions
            'view-inscriptions',
            'manage-inscriptions',
            
            // Séminaires
            'view-seminaires',
            'manage-seminaires',
            
            // Rapports
            'view-reports',
            'export-data',
            
            // Administration
            'manage-users',
            'view-logs',
            'manage-settings'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Création des rôles
        $superadmin = Role::create(['name' => 'superadmin']);
        $admin = Role::create(['name' => 'admin']);
        $professeur = Role::create(['name' => 'professeur']);

        // Attribution des permissions
        $superadmin->givePermissionTo(Permission::all());
        
        $admin->givePermissionTo([
            'view-dashboard',
            'view-membres', 'create-membres', 'edit-membres', 'approve-membres',
            'view-cours', 'create-cours', 'edit-cours', 'duplicate-cours',
            'view-presences', 'take-presences', 'edit-presences',
            'view-inscriptions', 'manage-inscriptions',
            'view-seminaires', 'manage-seminaires',
            'view-reports'
        ]);

        $professeur->givePermissionTo([
            'view-dashboard',
            'view-membres',
            'view-cours',
            'take-presences',
            'view-presences'
        ]);

        echo "✅ Permissions et rôles créés avec succès!\n";
    }
}
