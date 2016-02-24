<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use App\Jobs\SendEmail;
class CallFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'route:call';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Call a file from terminal';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(SendEmail $sendEmail)
    {
        $this->sendEmail = $sendEmail;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      
      $this->sendEmail->sendEmail();

    }
}
