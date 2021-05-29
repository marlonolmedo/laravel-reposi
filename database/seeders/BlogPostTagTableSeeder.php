<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;

class BlogPostTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tagcount = Tag::all()->count();

        if(0 === $tagcount){
            $this->command->info('Tag not found, skipping assigning tags to blog posts');
            return;
        }

        $howmanymin = (int)$this->command->ask('Minimum tag on blog post?', 0);
        $howmanymax = min((int)$this->command->ask('maximun tag on blog post?', $tagcount),$tagcount);

        \App\Models\BlogPost::all()->each(function (\App\Models\BlogPost $post) use ($howmanymin,$howmanymax){
            $take = random_int($howmanymin,$howmanymax);
            $tags = \App\Models\Tag::inRandomOrder()->take($take)->get()->pluck('id');
            $post->tags()->sync($tags);
        });
    }
}
