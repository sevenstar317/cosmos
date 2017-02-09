<?php

namespace App\Console\Commands;

use App\Models\AgentUser;
use Illuminate\Console\Command;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Log;
use DateTimeZone;
class ChatEnd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chat:end';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verify if user is offline and ends chat';

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

	    $chats = AgentUser::whereIn('chat_status',['Active','Pending'])->get();
	    foreach($chats as $chat){
		    $now = Carbon::now();
		    if(isset($chat->messages) && count($chat->messages) > 0) {
			    $last_mess = $chat->messages->last();
			    $created = new Carbon($last_mess->updated_at);
			    $diff_minutes = $created->diffInMinutes($now);
			    Log::debug($diff_minutes . ' ' . ' '.$chat->id . ' ' . $created . ' ' . $now . ' mess');
			    if($diff_minutes > 5){
				    $created2 = new Carbon($chat->updated_at);
				    $diff_minutes2 = $created2->diffInMinutes($now);
				    Log::debug($diff_minutes2. ' '. $created2. ' chat');
				    if($diff_minutes2 > 5) {

					    $chat->chat_status = 'Completed';
					    $chat->started_chat_on = NULL;
					    $chat->ended_chat_on = $now->getTimestamp() * 1000;
					    $chat->save();
				    }
			    }
		    }else{
			    $created = new Carbon($chat->updated_at);
			    $diff_minutes = $created->diffInMinutes($now);
			    if($diff_minutes > 5){

				    Log::debug($diff_minutes.' '. $chat->id.' '.$created.' '.$now);
				    $chat->chat_status = 'Archived';
				    $chat->customer_status = 'Disconnected';
				    $chat->started_chat_on = NULL;
				    $chat->ended_chat_on = $now->getTimestamp() * 1000;
				    $chat->save();
			    }
		    }
	    }
    }
}
