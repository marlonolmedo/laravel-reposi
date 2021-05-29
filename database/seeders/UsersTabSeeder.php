<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTabSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userscount = max((int)$this->command->ask('How many users would you like?', 20),1);
        \App\Models\User::factory()->state([
                'name' => 'marlon olmedo',
                'email' => 'marlon@laravel.test',
                'password' => '$2y$12$10N8zE06nn8T8lK71v3Qn.ftgQ0XhmXecgZitdAk8nrrkiH4tu93W', // password
                'is_admin' => true
            ])
            ->create();
        \App\Models\User::factory()->count($userscount)->create();
    }
}
