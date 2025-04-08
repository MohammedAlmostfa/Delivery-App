<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Create an admin user
        $adminUser = User::create([
            'name' => 'adminUser',
            'phone' => substr($faker->numerify('##########'), 0, 10),
            'email' => 'adminUser@gmail.com',
            'password' => bcrypt('P@ssw0rd123'),
        ]);
        $adminUser->assignRole('admin');

        // Create a manager user
        $managerUser = User::create([
            'name' => 'managerUser',
            'phone' => substr($faker->numerify('##########'), 0, 10),
            'email' => 'managerUser@gmail.com',
            'password' => bcrypt('P@ssw0rd123'),
        ]);
        $managerUser->assignRole('manager');
        // Create a manager user
        $userUser = User::create([
            'name' => 'userUser',
            'phone' => substr($faker->numerify('##########'), 0, 10),
            'email' => 'userUser@gmail.com',
            'password' => bcrypt('P@ssw0rd123'),
        ]);
        $userUser->assignRole('user');

        // Create random users
        for ($i = 0; $i < 10; $i++) {
            $user = User::create([
                'name' => $faker->name(),
                'phone' => substr($faker->numerify('##########'), 0, 10),
                'email' => $faker->unique()->safeEmail(),
                'password' => bcrypt('P@ssw0rd123'),
            ]);
            $user->assignRole($faker->randomElement(['admin', 'user', 'manager']));
        }
    }
}
