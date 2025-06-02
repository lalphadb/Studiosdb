<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Réinitialiser le cache des rôles et permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        
        // Créer les rôles
        $superadmin = Role::firstOrCreate(['name' => 'superadmin']);
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $instructeur = Role::firstOrCreate(['name' => 'instructeur']);
        $user = Role::firstOrCreate(['name' => 'user']);
        
        // Créer quelques permissions de base
        Permission::firstOrCreate(['name' => 'manage-all']);
        Permission::firstOrCreate(['name' => 'manage-ecole']);
        Permission::firstOrCreate(['name' => 'manage-cours']);
        Permission::firstOrCreate(['name' => 'manage-membres']);
        Permission::firstOrCreate(['name' => 'view-reports']);
        
        // Assigner toutes les permissions au superadmin
        $superadmin->givePermissionTo(Permission::all());
        
        // Assigner des permissions spécifiques aux autres rôles
        $admin->givePermissionTo(['manage-ecole', 'manage-cours', 'manage-membres', 'view-reports']);
        $instructeur->givePermissionTo(['manage-cours', 'view-reports']);
        
        echo "Rôles créés avec succès!\n";
    }
}
