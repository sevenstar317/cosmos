<?php

namespace App\Http\Controllers;

use App\Models\AgentUser;
use App\Models\Report;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use App\Models\Soap;
use App\Models\PaymentHistory;
use Illuminate\Support\Facades\Auth;
use Mail;
use Validator;
use App\Models\PaymentInfo;

class PaymentController extends Controller
{
	function sum_the_time($time1, $time2)
	{
		$times = array($time1, $time2);
		$seconds = 0;
		foreach ($times as $time) {
			list($hour, $minute, $second) = explode(':', $time);
			$seconds += $hour * 3600;
			$seconds += $minute * 60;
			$seconds += $second;
		}
		$hours = floor($seconds / 3600);
		$seconds -= $hours * 3600;
		$minutes = floor($seconds / 60);
		$seconds -= $minutes * 60;
		if ($seconds == 0) {
			$seconds = '00';
		}
		if ($hours == 0) {
			$hours = '00';
		}
		if ($minutes == 0) {
			$minutes = '00';
		}
		return "{$hours}:{$minutes}:{$seconds}";
	}

	/**
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function buyPackage()
	{
		$sku = Input::get('sku');
		$user = Auth::user();
		$soap = new Soap();
		$responce = $soap->processOrderExistingAccount($user->toArray(), $user->paymentInfo->toArray(), $sku);
		if (isset($responce['order_id'])) {

			$secs = $this->sum_the_time($user->minutes_balance, $responce['totalMinutes']);

			$user->minutes_balance = $secs;
			$user->save();

			$PaymentHistory = PaymentHistory::saveHistory($user, $responce);

			Mail::send('emails.purchase', ['user' => $user, 'responce' => $responce, 'PaymentHistory'=>$PaymentHistory], function ($message) use ($user) {
				$message->to($user->email);
				$message->subject('Live Cosmos - Your order was accepted.');
			});

			return response()
					->json(['success' => 'success']);
		} else {
			return response()
					->json(['error' => $responce['error']], 400);
		}
	}

	/**
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function quickCheckout(Request $request)
	{
		if ($request->isMethod('post')) {
			$user = Auth::user();
			$validator = Validator::make($request->all(), PaymentInfo::$rules);
			$payment = new PaymentInfo();
			$payment->fill($request->all());

			if ($validator->fails()) {
				return response()
						->json(['error' => $validator->errors() ], 400);
			} else {
				$payment->user_id = $user->id;
				$payment->card_name = Input::get('card_name');
				$payment->card_number = Input::get('card_number');
				$payment->card_month = Input::get('card_month');
				$payment->card_year = Input::get('card_year');
				$payment->card_cvv = Input::get('card_cvv');
				$payment->zip = Input::get('zip');


					$sku = Input::get('sku');
					$soap = new Soap();
					$responce = $soap->processLead($user->toArray(), $payment->toArray(), $sku);

					//  return view('main.end-flow');
					if (isset($responce['order_id']) && isset($responce['member_id'])) {
						$payment->save();

							$PaymentHistory = PaymentHistory::saveHistory($user, $responce);

							$user->member_id = $responce['member_id'];
							$user->minutes_balance = $responce['totalMinutes'];
							$user->save();


							Mail::send('emails.purchase', ['user' => $user, 'responce' => $responce, 'PaymentHistory'=>$PaymentHistory], function ($message) use ($user) {
								$message->to($user->email);
								$message->subject('Live Cosmos - Your order was accepted.');
							});

							return response()
									->json(['success' => 'success']);

					} else {
						return response()
								->json(['error' => $responce['error']], 400);
					}


			}
		}


	}

	/**
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function buyReport()
	{
		$sku = Input::get('sku');
		$other_user_id = Input::get('other_id');
		$user = Auth::user();
		$soap = new Soap();
		$responce = $soap->processOrderExistingAccount($user->toArray(), $user->paymentInfo->toArray(), $sku);
		if (isset($responce['order_id']) && isset($responce['type'])) {

			$reportGet = Helper::getReport($responce['type'], $other_user_id);
			if ($reportGet instanceof Report) {

				$PaymentHistory = PaymentHistory::saveHistory($user,$responce);
				Mail::send('emails.purchase', ['user' => $user, 'responce' => $responce, 'PaymentHistory'=>$PaymentHistory], function ($message) use ($user) {
					$message->to($user->email);
					$message->subject('Live Cosmos - Your order was accepted.');
				});
				return response()
					->json(['success' => 'success']);
			} else {
				return response()
					->json(['error' => $reportGet], 400);
			}
		} else {
			return response()
				->json(['error' => $responce['error']], 400);
		}
	}


	public function payForDownloadPdfReport($id)
	{
		$sku = '521628';
		$user = Auth::user();
		$soap = new Soap();
		$report = Report::where('id', $id)->first();

		if ($report->paid_for_download == "1") {
			return response()
				->json(['success' => 'success']);
		} else {

			$responce = $soap->processOrderExistingAccount($user->toArray(), $user->paymentInfo->toArray(), $sku);

			if (isset($responce['order_id'])) {
				$report->paid_for_download = "1";
				$report->save();

				$PaymentHistory = PaymentHistory::saveHistory($user,$responce);
				Mail::send('emails.purchase', ['user' => $user, 'responce' => $responce, 'PaymentHistory'=>$PaymentHistory], function ($message) use ($user) {
					$message->to($user->email);
					$message->subject('Live Cosmos - Your order was accepted.');
				});
				return response()
					->json(['success' => 'success']);
			} else {
				return response()
					->json(['error' => $responce['error']], 400);
			}
		}
	}

	public function payForEmailReport($id)
	{
		$sku = '521629';
		$user = Auth::user();
		$soap = new Soap();
		$report = Report::where('id', $id)->first();

		if ($report->paid_for_email == "1") {
			return response()
				->json(['success' => 'success']);
		} else {

			$responce = $soap->processOrderExistingAccount($user->toArray(), $user->paymentInfo->toArray(), $sku);

			if (isset($responce['order_id'])) {
				$report->paid_for_email = "1";
				$report->save();

				$PaymentHistory = PaymentHistory::saveHistory($user,$responce);
				Mail::send('emails.purchase', ['user' => $user, 'responce' => $responce, 'PaymentHistory'=>$PaymentHistory], function ($message) use ($user) {
					$message->to($user->email);
					$message->subject('Live Cosmos - Your order was accepted.');
				});
				return response()
					->json(['success' => 'success']);
			} else {
				return response()
					->json(['error' => $responce['error']], 400);
			}
		}
	}

	public function payForEmailChat($id)
	{
		$sku = '521625';
		$user = Auth::user();
		$soap = new Soap();
		$chat = AgentUser::find($id);

		if ($chat->paid_for_email == "1") {
			return response()
					->json(['success' => 'success']);
		} else {

			$responce = $soap->processOrderExistingAccount($user->toArray(), $user->paymentInfo->toArray(), $sku);

			if (isset($responce['order_id'])) {
				$chat->paid_for_email = "1";
				$chat->save();

				$PaymentHistory = PaymentHistory::saveHistory($user,$responce);
				Mail::send('emails.purchase', ['user' => $user, 'responce' => $responce, 'PaymentHistory'=>$PaymentHistory], function ($message) use ($user) {
					$message->to($user->email);
					$message->subject('Live Cosmos - Your order was accepted.');
				});

				return response()
						->json(['success' => 'success']);
			} else {
				return response()
						->json(['error' => $responce['error']], 400);
			}
		}
	}

	public function payForDownloadChat($id)
	{
		$sku = '521625';
		$user = Auth::user();
		$soap = new Soap();
		$chat = AgentUser::find($id);

		if ($chat->paid_for_download == "1") {
			return response()
					->json(['success' => 'success']);
		} else {

			$responce = $soap->processOrderExistingAccount($user->toArray(), $user->paymentInfo->toArray(), $sku);

			if (isset($responce['order_id'])) {
				$chat->paid_for_download = "1";
				$chat->save();

				$PaymentHistory = PaymentHistory::saveHistory($user,$responce);
				Mail::send('emails.purchase', ['user' => $user, 'responce' => $responce, 'PaymentHistory'=>$PaymentHistory], function ($message) use ($user) {
					$message->to($user->email);
					$message->subject('Live Cosmos - Your order was accepted.');
				});
				return response()
						->json(['success' => 'success']);
			} else {
				return response()
						->json(['error' => $responce['error']], 400);
			}
		}
	}

}
