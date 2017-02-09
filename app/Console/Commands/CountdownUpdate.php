<?php

namespace App\Console\Commands;

use App\Models\Timer;
use Illuminate\Console\Command;

class CountdownUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'countdown:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $timer = Timer::findOrNew(1);
        $timer->count_down_date = date("Y/m/d",strtotime("+3 days"));
        $timer->save();
    }
}
