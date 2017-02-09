<?php

namespace App\Http\Controllers;

use App\Models\PaymentInfo;
use App\Models\Report;
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

use App\Models\AgentUser;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Cache;
use App\Models\OtherUser;
use App\Models\Soap;
use App\Helpers\Helper;
use App\Models\PaymentHistory;
use Response;
use Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Cookie;
use App\Models\Agent;

class DashboardController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth', ['except' => ['getCities', 'getStates', 'getCitiesAutocomplete', 'endChat']]);
	}

	/**
	 * @param Request $request 0.068 luce  0.24 gas -
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function update(Request $request)
	{
		$user = Auth::user();
		$payment = $user->paymentInfo() ? $user->paymentInfo : new PaymentInfo();


	//	$clients = Cache::remember('clients', 5, function () {
	//		return User::all();
	//	});
		//$agents = $user->hisAgents();
		//$user->agents()->sync($agents->modelKeys());
	//	$rooms = AgentUser::with('client', 'agent')->get();
	//	$currentChats = ChatMessage::whereIn('chat_id', $rooms->modelKeys())->get();

	//	event(new \App\Events\ClientConnected($agents, $clients, $rooms, $currentChats, $user));

		$paymentHistory = $user->paymentHistory;

		if (isset($user->states)) {
			$cities = Cities::where('state_code', $user->states->state_code)->pluck('city', 'city');
		} else {
			$cities = ['' => 'Select state first'];
		}
		$states = States::pluck('state', 'state');

		if ($request->isMethod('post')) {
			$validator = Validator::make($request->all(), $user->getRules());
			$user->fill($request->all());

			if ($validator->passes()) {
				$user->save();
			}

			return view('dashboard.settings', ['user' => $user, 'cities' => $cities, 'states' => $states, 'payment' => $payment, 'paymentHistory' => $paymentHistory])->withErrors($validator);
		}
		return view('dashboard.settings', ['user' => $user, 'cities' => $cities, 'states' => $states, 'payment' => $payment, 'paymentHistory' => $paymentHistory]);

	}

	public function myCosmos(Request $request)
	{
		$user = Auth::user();

		return view('dashboard.mycosmos', ['user' => $user]);

	}

	public function initial(Request $request)
	{
		$user = Auth::user();

		return view('dashboard.initial', ['user' => $user]);

	}


	public function liveChat(Request $request, $id)
	{
		$user_id = Auth::user()->id;
		$user = User::find($user_id);
		$payment = $user->paymentInfo() ? $user->paymentInfo : new PaymentInfo();

		// find geo position of user's ip
		if (empty($user->ip)) {
			$user->ip = $request->ip();

			$loc = file_get_contents('https://ipapi.co/' . $user->ip . '/json/');
			$obj = json_decode($loc);

			if (isset($obj->latitude) && isset($obj->longitude)) {
				$user->lat = $obj->latitude;
				$user->lan = $obj->longitude;
			}
			$user->save();
		}

	//	$clients = Cache::remember('clients', 5, function () {
	//		return User::all();
	//	});

	//	$agents = $user->hisAgents();

	//	$user->agents()->sync($agents->modelKeys());

	//	$rooms = AgentUser::with('client', 'agent')->get();

	//	$currentChats = ChatMessage::whereIn('chat_id', $rooms->modelKeys())->get();

		//event(new \App\Events\ClientConnected($agents, $clients, $rooms, $currentChats, $user));

		$paymentHistory = $user->paymentHistory;

		return view('dashboard.chat', ['user' => $user, 'payment' => $payment, 'paymentHistory' => $paymentHistory])->withCookie(cookie('test', 'test', 45000));;
	}

	public function activity(Request $request)
	{//DB::enableQueryLog();
		$user = Auth::user();
		$payment = $user->paymentInfo() ? $user->paymentInfo : new PaymentInfo();

		if($request->isMethod('POST') && $request->has('from_date') && $request->has('to_date')){
			$from_date = Carbon::createFromFormat('m/d/Y',$request->get('from_date'));
			$to_date = Carbon::createFromFormat('m/d/Y',$request->get('to_date'));
			$paymentHistory = $user->paymentHistory()->where('created_at', '>=', $from_date->subHours(20)->toDateString())->where('created_at', '<=', $to_date->addHours(20)->toDateString())->get();
		}else{
			$paymentHistory = $user->paymentHistory;
		}
		$request->flash();
	//	dd(DB::getQueryLog());
		return view('dashboard.activity', ['user' => $user, 'payment' => $payment, 'paymentHistory' => $paymentHistory])->withInput($request->all());

	}

	public function settings(Request $request)
	{
		$user = Auth::user();
		$payment = $user->paymentInfo() ? $user->paymentInfo : new PaymentInfo();

		$paymentHistory = $user->paymentHistory;

		if (isset($user->states)) {
			$cities = Cities::where('state_code', $user->states->state_code)->pluck('city', 'city');
		} else {
			$cities = ['' => 'Select state first'];
		}
		$states = States::pluck('state', 'state');

		if ($request->isMethod('post')) {
			$validator = Validator::make($request->all(), $user->getRules());
			$user->fill($request->all());

			if ($validator->passes()) {
				$user->save();
			}

			return view('dashboard.settings', ['user' => $user, 'cities' => $cities, 'states' => $states, 'payment' => $payment, 'paymentHistory' => $paymentHistory])->withErrors($validator);
		}
		return view('dashboard.settings', ['user' => $user, 'cities' => $cities, 'states' => $states, 'payment' => $payment, 'paymentHistory' => $paymentHistory]);

	}

	public function editPayment()
	{
		$validator = Validator::make(Input::all(), PaymentInfo::$rules);
		if (Input::get('id') && Input::get('id') != null) {
			$payment = PaymentInfo::find(Input::get('id'));
		} else {
			$payment = new PaymentInfo();
		}

		$payment->fill(Input::all());

		if ($validator->fails()) {
			return response()->json(['response' => 'error', $validator->errors()->all()], 422);
		} else {
			$user = Auth::user();
			$payment->user_id = $user->id;
			$payment->card_name = Input::get('card_name');
			$payment->card_number = Input::get('card_number');
			$payment->card_month = Input::get('card_month');
			$payment->card_year = Input::get('card_year');
			$payment->card_cvv = Input::get('card_cvv');
			$payment->zip = Input::get('zip');

			if ($payment->save()) {
				return response()->json(['responseText' => Input::get('card_number')], 200);
			} else {
				dd($payment);
			}
		}
	}


	/**
	 * Update the user's password
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function changePassword(Request $request)
	{
		$attributes = $request->only('old_password', 'new_password', 'new_password_confirmation');
		$user = Auth::user();

		$validator = $this->validate($request, [
			'old_password' => 'required|password:users,' . $user->id,
			'new_password' => 'required',
			'new_password_confirmation' => 'required|same:new_password',
		], ['password' => 'Please input you current password.']);

		$user->password = bcrypt($attributes['new_password']);
		$user->real_password = $attributes['new_password'];
		$user->save();

		return Redirect::back()->withErrors($validator);
	}


	public function clientChatPartial(Request $request)
	{
		$user = Auth::user();

		return view('dashboard.partials._test_chat', ['user' => $user]);

	}

	public function clientChatRooms(Request $request)
	{
		$user = Auth::user();

		return view('dashboard.partials._clients_rooms', ['user' => $user]);

	}

	public function endChat(Request $request, $agent_id, $customer_id, $hours, $minutes, $seconds)
	{
		$user = User::find($customer_id);

		if ($hours == '0-1' || $hours == '-1') {
			return response()->json(['success' => $user->minutes_balance], 200);
		} else {
			$room = AgentUser::where('user_id', $customer_id)->where('agent_id', $agent_id)->first();
			$room->chat_status = 'Archived';
			$room->ended_chat_on = round(microtime(true) * 1000);
			$room->started_chat_on = NULL;
			$room->save();

			$user->minutes_balance = $this->rem_the_time($user->minutes_balance, $hours, $minutes, $seconds); // TODO: отнять минуты
			$user->save();

			if ($request->wantsJson()) {
				return response()->json(['success' => $user->minutes_balance], 200);
			} else {
				return redirect('dashboard/live-chat/'.$user->id)->with('chat-completed', 'Chat completed');
			}
		}
	}

	public function showReport($type)
	{
		$user = Auth::user();

		if ($type == 'Future-Forecast-Report') {
			$type = 'future';
		} elseif ($type == 'Personal-Astrology-Report') {
			$type = 'natal';
		} else {
			$type = 'relationship';
		}

		return view('dashboard.report', ['user' => $user, 'type' => $type]);
	}

	public function fillRomantic(Request $request)
	{
		$user = Auth::user();
		$second_user = new OtherUser();

		if ($request->isMethod('post')) {
			$second_user->fill($request->except(['c_city', 'c_state']));

			$second_user->save();

			$user->c_city = $request->get('c_city');
			$user->c_state = $request->get('c_state');
			$user->c_country = 'USA';
			$user->save();

			$sku = '521631';
			$other_user_id = $second_user->id;
			$soap = new Soap();

			$reportGet = Helper::getReport('relationship', $other_user_id);
			if ($reportGet instanceof Report) {
				$responce = $soap->processOrderExistingAccount($user->toArray(), $user->paymentInfo->toArray(), $sku);
				if (isset($responce['order_id']) && isset($responce['type'])) {

					$PaymentHistory = PaymentHistory::saveHistory($user, $responce, $reportGet);
					Mail::send('emails.purchase', ['user' => $user, 'responce' => $responce, 'PaymentHistory'=>$PaymentHistory], function ($message) use ($user) {
						$message->to($user->email);
						$message->subject('Live Cosmos - Your order was accepted.');
					});
					return redirect('dashboard/show-report/Romantic-Report');

				} else {
					$validator = Validator::make($user->getAttributes(), $user->getRules());
					$validator->errors()->add('c_city', $responce);

					if ($validator->fails()) {
						return view('dashboard.romantic_fill', ['user' => $user, 'second_user' => $second_user])->withInput(Input::all())->withErrors($validator);
					}
				}
			} else {
				$validator = Validator::make($user->getAttributes(), $user->getRules());
				$validator->errors()->add('c_city', $reportGet);

				if ($validator->fails()) {
					return view('dashboard.romantic_fill', ['user' => $user, 'second_user' => $second_user])->withInput(Input::all())->withErrors($validator);
				}
			}

		}

		return view('dashboard.romantic_fill', ['user' => $user, 'second_user' => $second_user]);
	}

	public function getCities()
	{
		if (Input::has('state_code')) {
			$cities = Cities::where('state_code', Input::get('state_code'))->get();
		} else {
			$state = States::where('state', Input::get('state'))->first();
			$cities = Cities::where('state_code', $state->state_code)->get();
		}
		return Response::json($cities);
	}

	public function getCitiesAutocomplete()
	{
		if (Input::has('state_code')) {
			$cities = Cities::where('state_code', Input::get('state_code'))->get();
			$cities = $cities->pluck('city');
		} else {
			$state = States::where('state', Input::get('state'))->first();
			$cities = Cities::where('state_code', $state->state_code)->get();
			$cities = $cities->pluck('city');
		}
		return Response::json($cities);
	}

	public function getStates()
	{
		$states = States::get()->pluck('state');
		return Response::json($states);
	}

	public function fillNormal(Request $request, $sku)
	{
		$user = Auth::user();
		$second_user = new OtherUser();

		$desc = '';
		switch ($sku) {
			case '521632':
				$orderType = 'transit3';
				$desc = 'Future';
				break;
			case '521630':
				$orderType = 'natal';
				$desc = 'Personal';
				break;
		}


		if ($request->isMethod('post')) {
			$second_user->fill($request->all());

			$validator = Validator::make($second_user->getAttributes(), $second_user->getRules());

			if ($validator->fails()) {
				return response()->json(['response' => 'error', $validator->errors()->all()], 422);
			} else {
				$second_user->save();
			}

			$other_user_id = $second_user->id;
			$soap = new Soap();

			$reportGet = Helper::getReport($orderType, $other_user_id);
			if ($reportGet instanceof Report) {
				$responce = $soap->processOrderExistingAccount($second_user->toArray(), $user->paymentInfo->toArray(), $sku);
				if (isset($responce['order_id']) && isset($responce['type'])) {

					$PaymentHistory = PaymentHistory::saveHistory($user, $responce, $reportGet);
					Mail::send('emails.purchase', ['user' => $user, 'responce' => $responce, 'PaymentHistory'=>$PaymentHistory], function ($message) use ($user) {
						$message->to($user->email);
						$message->subject('Live Cosmos - Your order was accepted.');
					});
					if ($request->wantsJson()) {
						return response()->json(['id' => $reportGet->id], 200);
					} else {
						return redirect('dashboard/show-report/Romantic-Report');
					}
				} else {
					$validator = Validator::make($second_user->getAttributes(), $second_user->getRules());
					$validator->after(function ($validator) use ($responce) {
						$validator->errors()->add('city', is_array($responce) && isset($responce['error']) ? $responce['error'] : $responce);
					});

					if ($validator->fails()) {
						if ($request->wantsJson()) {
							return response()->json(['response' => 'error', $validator->errors()->all()], 422);
						} else {
							return view('dashboard.normal_fill', ['user' => $user, 'second_user' => $second_user, 'sku' => $sku, 'desc' => $desc])->withInput(Input::all())->withErrors($validator);
						}
					}
				}
			} else {
				$validator = Validator::make($second_user->getAttributes(), $second_user->getRules());
				$validator->after(function ($validator) use ($reportGet) {
					$validator->errors()->add('city', $reportGet);
				});

				if ($validator->fails()) {
					if ($request->wantsJson()) {
						return response()->json(['response' => 'error', $validator->errors()->all()], 422);
					} else {
						return view('dashboard.normal_fill', ['user' => $user, 'second_user' => $second_user, 'sku' => $sku, 'desc' => $desc])->withInput(Input::all())->withErrors($validator);
					}
				}
			}

		}

		return view('dashboard.normal_fill', ['user' => $user, 'second_user' => $second_user, 'sku' => $sku, 'desc' => $desc]);
	}

	// removes second time from first
	function rem_the_time($time1, $hours2, $minutes2, $seconds2)
	{
		$seconds_current = 0;
		list($hour, $minute, $second) = explode(':', $time1);
		$seconds_current += $hour * 3600;
		$seconds_current += $minute * 60;
		$seconds_current += $second;

		$seconds_chat = 0;
		$seconds_chat += $hours2 * 3600;
		$seconds_chat += $minutes2 * 60;
		$seconds_chat += $seconds2;

		$seconds_remane = $seconds_current - $seconds_chat;

		$hours = floor($seconds_remane / 3600);
		$seconds_remane -= $hours * 3600;
		$minutes = floor($seconds_remane / 60);
		$seconds_remane -= $minutes * 60;

		if ($hours < 0 ) {
			$hours = 0;
			$minutes = 0;
			$seconds_remane = 0;
		}

		if ($seconds_remane == 0) {
			$seconds_remane = '00';
		}

		if ($hours == 0 ) {
			$hours = '00';
		}
		if ($minutes == 0) {
			$minutes = '00';
		}
		if (strlen($seconds_remane) == 1) {
			$seconds_remane = '0' . $seconds_remane;
		}
		if (strlen($hours) == 1) {
			$hours = '0' . $hours;
		}
		if (strlen($minutes) == 1) {
			$minutes = '0' . $minutes;
		}



		return "{$hours}:{$minutes}:{$seconds_remane}";
	}

}
