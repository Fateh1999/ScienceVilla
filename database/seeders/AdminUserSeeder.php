<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Create admin user if it doesn't exist
        $adminUser = User::where('email', 'admin@Fateh Science Villa.com')->first();
        
        if (!$adminUser) {
            User::create([
                'name' => 'Admin User',
                'email' => 'admin@Fateh Science Villa.com',
                'email_verified_at' => now(),
                'password' => Hash::make('admin123'),
                'dob' => '1990-01-01',
                'country' => 'in',
                'is_admin' => true,
                'admin_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            $this->command->info('Admin user created successfully!');
            $this->command->info('Email: admin@Fateh Science Villa.com');
            $this->command->info('Password: admin123');
        } else {
            // Update existing user to be admin
            $adminUser->update([
                'is_admin' => true,
                'admin_verified_at' => now(),
            ]);
            
            $this->command->info('Existing user updated to admin!');
        }
    }
}
