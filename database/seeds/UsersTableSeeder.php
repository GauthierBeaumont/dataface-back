<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('fr_FR');

        foreach(range(1, 10) as $index)
        {
            User::create([
                'lastname' => $faker->lastName,
                'firstname' => $faker->firstName,
                'email' => $faker->email,
                'email_valide' => 1,
                'last_connect' => date('Y-m-d H:i:s'),
                'spam' => 0,
                'password' => bcrypt('secret'),
                'coordinate_id' => $index,
                'role_id' => rand(1, 2),
            ]);
        }

    }
}
