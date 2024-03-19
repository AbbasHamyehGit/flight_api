<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    public function run()
    {
        // Create Super Admin role
        $superAdminRole = Role::create(['name' => 'super-admin']);

        // Find user by email and assign Super Admin role
        $user = User::where('email', 'abbashamyeh@gmail.com')->first();

        if ($user) {
            $user->assignRole($superAdminRole);
        } else {
            // Create the user if not found
            $user = User::create([
                'name' => 'Super Admin',
                'email' => 'superadmin@example.com',
                'password' => bcrypt('password'), 
            ]);

            // Assign Super Admin role
            $user->assignRole($superAdminRole);
        }
    }
}
