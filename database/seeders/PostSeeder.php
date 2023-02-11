<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = ["Blue", "Red", "Green", "Yellow", "Magenta", "Black", "White", "Cyan", "Pink"];

        $posts = \App\Models\Post::factory(10)->create();

        foreach($posts as $post) {
            for($i=0; $i<rand(1,3); $i++) {
                $tag = $tags[array_rand($tags,1)];
                $post->tag($tag);
            }
            $post->save();
        }
    }
}
