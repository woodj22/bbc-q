<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\JobCollector;
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
    public function __construct(JobCollector $jobCollector)
    {
           $this->jobCollector= $jobCollector;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
         $this->line('php output:  ');
         $this->jobCollector->searchTable();
         $this->line('');


    }
}
