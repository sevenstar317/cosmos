<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Agent;
use App\Models\ChatMessage;
use App\User;
use Illuminate\Http\Request;
use LRedis;
use Auth;
use App\Models\AgentUser;
use Illuminate\Support\Facades\Response;

class AgentController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('agent');
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('agent.index');
	}

	public function info()
	{
		$file = base_path().'/public/images/info.pdf';

		if (file_exists($file)) {
			$content = file_get_contents($file);
			return Response::make($content, 200, array('content-type'=>'application/pdf'));
		}
	}

	public function info2()
	{
		$file = base_path().'/public/guides/AstrologyHousestheirMeaning.pdf';

		if (file_exists($file)) {
			$content = file_get_contents($file);
			return Response::make($content, 200, array('content-type'=>'application/pdf'));
		}
	}

	public function info3()
	{
		$file = base_path().'/public/guides/opening_script.pdf';

		if (file_exists($file)) {
			$content = file_get_contents($file);
			return Response::make($content, 200, array('content-type'=>'application/pdf'));
		}
	}

	public function info4()
	{
		$file = base_path().'/public/guides/cheat.pdf';

		if (file_exists($file)) {
			$content = file_get_contents($file);
			return Response::make($content, 200, array('content-type'=>'application/pdf'));
		}
	}

	public function info5()
	{
		$file = base_path().'/public/guides/houses.pdf';

		if (file_exists($file)) {
			$content = file_get_contents($file);
			return Response::make($content, 200, array('content-type'=>'application/pdf'));
		}
	}


	public function sign1($sign)
	{
		$file = base_path().'/public/guides/1/'.$sign.'.pdf';

		// check if the file exists
		if (file_exists($file)) {
			// Get the file content to put into your response
			$content = file_get_contents($file);
			//Build your Laravel Response with your content, the HTTP code and the Header application/pdf
			return Response::make($content, 200, array('content-type'=>'application/pdf'));
		}
	}

	public function sign2($sign)
	{
		$file = base_path().'/public/guides/2/'.$sign.'.pdf';

		// check if the file exists
		if (file_exists($file)) {
			// Get the file content to put into your response
			$content = file_get_contents($file);
			//Build your Laravel Response with your content, the HTTP code and the Header application/pdf
			return Response::make($content, 200, array('content-type'=>'application/pdf'));
		}
	}


	public function sendMessage()
	{
		$agent = Auth::guard('agent')->user();
		$redis = LRedis::connection();
		$data = ['agent' => $agent];
		$redis->publish('message', json_encode($data));
		return response()->json([]);
	}


	public function agentChat()
	{
		$agent = Auth::guard('agent')->user();
	//	$clients = User::all();
	//	$agents = Agent::all();

		//$agent->customers()->sync($clients->modelKeys());

	//	$rooms = AgentUser::with('client', 'agent')->get();

	//	$currentChats = ChatMessage::whereIn('chat_id', $rooms->modelKeys())->get();

	//	event(new \App\Events\AgentConnected($agents, $clients, $rooms, $currentChats, $agent));

		return view('agent.chat', ['user' => $agent]);

	}

	public function firstRedirect(){

		$agent = Auth::guard('agent')->user();
		$clients = User::all();

		if(count($agent->customers) == 0) {
		//	$agent->customers()->sync($clients->modelKeys());
		}

		$room = AgentUser::where('agent_id', $agent->id)->first();

	//	return redirect('agent/#/agents/'.$room->id  .'/'.$agent->id.'/'.$room->user_id)->with('new-user','New user created.');
		return redirect('chat-advisor/#/agents/'.$agent->id)->with('new-user','New user created.');
	}

	public function agentChatPartial(Request $request)
	{
		$user 	= Auth::guard('agent')->user();


		return view('agent.partials._agents_rooms', ['user' => $user]);

	}

	public function agentChatRoomPartial(Request $request)
	{
		$user 	= Auth::guard('agent')->user();

		return view('agent.partials._test_chat', ['user' => $user]);

	}

	public function endChat(Request $request, $agent_id, $customer_id)
	{
		$room = AgentUser::where('user_id', $customer_id)->where('agent_id', $agent_id)->first();
		$room->chat_status = 'Archived';
		$room->save();


		return redirect('/chat-advisor/first-redirect')->with('chat-completed','Chat completed');

	}



}
