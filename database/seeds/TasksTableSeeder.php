<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Task;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tasks')->delete();
        $faker = Faker\Factory::create();
        foreach(range(1,10) as $index)
        {
            Task::create([
                'task' => $faker->realText($maxNbChars = 30),
                'description'  => $faker->realText($maxNbChars = 50),
            ]);
        }
    }
}
