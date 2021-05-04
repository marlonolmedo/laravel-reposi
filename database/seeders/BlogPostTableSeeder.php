<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BlogPostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        $blogpostcount = (int)$this->command->ask('How many blog post would you like?', 50);
        $users = \App\Models\User::all();
        \App\Models\BlogPost::factory()->count($blogpostcount)->make()->each(function ($post) use ($users){
            $post->user_id = $users->random()->id;
            $post->save();
        });
    }
}
