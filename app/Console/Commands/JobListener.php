<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\http\Controllers\JobController;
class JobListener extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queue:listen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'listen for status field changes';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(JobController $jobController)
    {
           $this->jobController= $jobController;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
         //$this->line('php output:  ');
         $this->jobController->searchTable();
      //   $this->line('');


    }
}
