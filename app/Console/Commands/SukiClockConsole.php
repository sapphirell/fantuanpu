<?php

namespace App\Console\Commands;

use App\Http\Controllers\System\ServeController;
use Illuminate\Console\Command;

class SukiClockConsole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'suki:clock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'suki的clock';

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
        $serve = new ServeController();
        $serve->clock_alert();
    }
}
