<?php
 
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Posts;
 
class PostsTableSeeder extends Seeder{
    public function run()
    {
        foreach(range(1,50) as $index)
        {
            Posts::create([
                'title' => 'name'.$index,
                'slug'  => 'slug'.$index,
                'description'=> 'description'.$index,
                'content' => 'content'.$index
            ]);
        }
    }
}