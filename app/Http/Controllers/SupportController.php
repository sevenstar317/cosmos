<?php

namespace App\Http\Controllers;

use App\Models\AgentUser;
use App\Models\ChatMessage;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Carbon\Carbon;

class SupportController extends Controller
{
	public function chatSearch(Request $request)
	{
		if(!$request->session()->has('logged')){
			return redirect()->route('chat.login');
		}
		if($request->isMethod('post')) {
			if($request->has('email')){
				$user = User::where('email',$request->get('email'))->first();
				if($user){
					$rooms = AgentUser::where('user_id',$user->id)->with('messages','agent','client')->get();
					$chats = [];

					foreach($rooms as $room){
						if(count($room->messages) > 0){
							$i = 1;

							foreach($room->messages as $message){
								$chats[$room->id.'_'.$i]['messages'][] = $message->toArray();
							//	$chats[$room->id.'_'.$i]['room'] = ['id' => $room->id,'agent'=>$room->agent->name];
								if($message->message === '---------------- Client left the room, You can close the chat. ------------------'){
									$chats[$room->id.'_'.$i]['room']  = [
											'id' => $room->id,
											'agent'=>$room->agent->name,
											'client' => $room->client->first_name.' '.$room->client->last_name,
											'date' => substr($message->created_at,0,10)
									];
									$i++;
								}
							}

						}
					}
					$new_chat = [];
					foreach($chats as $key => $chat){



						$first = $chat['messages'][0]['created_at'];
						$last = end($chat['messages'])['created_at'];

						$created = new Carbon($first);
						$ended = new Carbon($last);

						$chat['room']['length'] = $created->diff($ended)->format('%H:%I:%S');


						if(count($chat) <= 2 && $chat['messages'][0]['message'] === '---------------- Client left the room, You can close the chat. ------------------'){
							unset($chats[$key]);
						}else{
							$new_chat[] = $chat;
						}

					}

					return view('support.chat_search',['rooms'=>$rooms, 'user'=>$user, 'chats'=>$new_chat]);
				}
			}
		}
		return view('support.chat_search');
	}

	public function fakeLogin(Request $request)
	{
		if($request->isMethod('post')){
			if($request->get('email') == 'admin' && $request->get('password') == '1q2w3e4r5t'){
				$request->session()->put('logged', 'admin');
				return redirect()->route('chat.search');
			}
		}

		return view('support.fake_login');
	}

}
