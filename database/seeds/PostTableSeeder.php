<?php

use Illuminate\Database\Seeder;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $post = new \App\Post([
            'title' => 'Seeded post #1',
            'content' => 'Seeded post #1 content'
        ]);
        $post->save();    

        $post = new \App\Post([
            'title' => 'Seeded post #2',
            'content' => 'Seeded post #2 content'
        ]);
        $post->save(); 
    }
}
