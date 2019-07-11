<?php

namespace App\Console\Commands;

use App\API\Service\ApiSetState;
use Illuminate\Console\Command;

class SendStateStore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send-state';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send state store to system';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        app(ApiSetState::class)->send();
    }
}
