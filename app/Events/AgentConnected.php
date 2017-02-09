<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AgentConnected extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $agents = [];
    public $clients = [];
    public $rooms = [];
    public $user;
    public $currentChats = [];
    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($agents, $clients, $rooms, $currentChats, $agent)
    {
        $this->clients = $clients;
        $this->agents = $agents;
        $this->rooms = $rooms;
        $this->user = $agent;

        /*
        foreach($currentChats as $chat){
            $newChat = new \stdClass();
            $newChat->when = $chat->created_at->format('D M d Y H:i:s O');
            if ($chat->sender_type == 'agent') {
                $newChat->sender = $chat->senderAgent;
            } else {
                $newChat->sender = $chat->senderClient;
            }
            $newChat->message = $chat->message;
            $newChat->sender_type = $chat->sender_type;
            $this->currentChats[$chat->chat_id][]  = $newChat;
        }
        */


    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['agent-chat-channel'];
    }
}
