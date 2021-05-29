<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = collect(['Science','Sport','Politics','Entartainment','Economy']);

        $tags->each(function ($tagname){
            $tag = new Tag();
            $tag->name = $tagname;
            $tag->save();
        });

    }
}
