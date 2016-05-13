<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\BlogPosts;

class BlogPostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('blog-posts')->delete();
        
        $faker = Faker\Factory::create();
        foreach(range(1,10) as $index)
        {
            BlogPosts::create([
                'title' => $faker->realText($maxNbChars = 50),
                'description'  => $faker->realText($maxNbChars = 100),
                'content' => $faker->realText($maxNbChars = 500),
            ]);
        }
    }
}
