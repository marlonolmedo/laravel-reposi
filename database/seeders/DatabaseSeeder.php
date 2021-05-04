<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // $doe = \App\Models\User::factory()->state([
        //         'name' => 'marlon olmedo',
        //         'email' => 'marlon@laravel.test',
        //         'password' => '$2y$12$10N8zE06nn8T8lK71v3Qn.ftgQ0XhmXecgZitdAk8nrrkiH4tu93W', // password
        //     ])
        //     ->create();
        // $else = \App\Models\User::factory()->count(20)->create();

        // $users = $else->concat([$doe]);
        //     //dd($doe);
        // $posts = \App\Models\BlogPost::factory()->count(50)->make()->each(function ($post) use ($users){
        //     $post->user_id = $users->random()->id;
        //     $post->save();
        // });

        // $comments = \App\Models\Comment::factory()->count(150)->make()->each(function ($comment) use ($posts){
        //     $comment->blog_post_id = $posts->random()->id;
        //     $comment->save();
        // }); 
        if($this->command->confirm('Do you want to refresh the database?',true)){
            $this->command->call('migrate:refresh');
            $this->command->info('Database was refresed');
        }
        $this->call([
                UsersTabSeeder::class,
                BlogPostTableSeeder::class,
                CommentsTableSeeder::class
        ]);
    }
}
