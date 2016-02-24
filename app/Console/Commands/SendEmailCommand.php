<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use App\Jobs\SendEmail;
class SendEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'fires sendEmail() which uses App\Jobs\SendEmail';

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
