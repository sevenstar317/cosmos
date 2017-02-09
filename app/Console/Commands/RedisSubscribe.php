<?php

namespace App\Console\Commands;
use LRedis;
use Illuminate\Console\Command;
use App\Models\PaymentInfo;
use App\Models\States;
use App\User;
use App\Validators\CosmosValidator;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Models\Cities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;


use Illuminate\Support\Facades\Mail;
use App\Models\Agent;
use App\Models\AgentUser;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class RedisSubscribe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'redis:subscribe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Subscribe to a Redis channel';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        LRedis::subscribe(['need-info-channel'], function($message) {

echo 'fired';
        });
    }
}

