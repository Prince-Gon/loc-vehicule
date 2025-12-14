<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Client;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $permissions = [
      'view_admin_panel',
      'view_client_panel',
      'view_vehicles',
      'create_vehicles',
      'edit_vehicles',
      'delete_vehicles',
      'view_clients',
      'create_clients',
      'edit_clients',
      'delete_clients',
      'view_all_contracts',
      'create_contracts',
      'edit_all_contracts',
      'delete_contracts',
      'view_own_contracts',
      'cancel_own_contracts',
      'view_brands',
      'create_brands',
      'edit_brands',
      'delete_brands',
    ];

    foreach ($permissions as $permission) {
      Permission::firstOrCreate(['name' => $permission]);
    }

    $adminRole = Role::firstOrCreate(['name' => 'admin']);
    $adminRole->givePermissionTo([
      'view_admin_panel',
      'view_vehicles',
      'create_vehicles',
      'edit_vehicles',
      'delete_vehicles',
      'view_clients',
      'create_clients',
      'edit_clients',
      'delete_clients',
      'view_all_contracts',
      'create_contracts',
      'edit_all_contracts',
      'delete_contracts',
      'view_brands',
      'create_brands',
      'edit_brands',
      'delete_brands',
    ]);

    $clientRole = Role::firstOrCreate(['name' => 'client']);
    $clientRole->givePermissionTo([
      'view_client_panel',
      'view_vehicles',
      'create_contracts',
      'view_own_contracts',
      'cancel_own_contracts',
    ]);

    // Create a default admin user
    $admin = User::firstOrCreate([
      'name' => 'Admin User',
      'email' => 'admin@location.com',
      'password' => Hash::make('password'),
      'email_verified_at' => now(),
    ]);

    $admin->assignRole('admin');

    // Create a default client user
    $clientUser = User::firstOrCreate([
      'name' => 'John Doe',
      'email' => 'client@test.com',
      'password' => Hash::make('password'),
      'email_verified_at' => now(),
    ]);
    $clientUser->assignRole('client');

    // Create the associated Client profile
    Client::firstOrCreate([
      'user_id' => $clientUser->id,
      'first_name' => 'John',
      'last_name' => 'Doe',
      'email' => 'client@test.com',
      'phone_number' => '0612345678',
      'driver_license_number' => 'TEST123456789',
      'address' => '123 Rue de la Paix, 75001 Paris, France',
    ]);

    $this->command->info('✅ Rôles et permissions créés avec succès !');
    $this->command->info('');
    $this->command->info('🔐 Comptes de test :');
    $this->command->info('Admin : admin@location.com / password');
    $this->command->info('Client : client@test.com / password');
  }
}
