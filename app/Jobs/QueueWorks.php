<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class QueueWorks extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    
    protected $input; 
    protected $function;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($input, $function)
    {
        $this->input = $input;
        $this->function = $function;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if($this->function == 'news')
        {
            $news = new \App\News();

            $data = $this->input;

            $news::create($data);
        }
        if($this->function == 'posts')
        {
            $posts = new \App\Posts();

            $data = $this->input;
            
            $posts::create($data);
        }
    }
}
