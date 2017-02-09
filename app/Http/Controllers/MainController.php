<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\AgentUser;
use App\Models\Cities;
use App\Models\PaymentHistory;
use App\Models\PaymentInfo;
use App\Models\Soap;
use App\User;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\States;
use App\Http\Requests;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Helpers\Helper;

class MainController extends Controller {

    public function __construct() {
        $this->middleware('guest');
    }

    public function index(Request $request) {
        if (isset($_GET['affid'])) {
            $request->session()->put('AID', $_GET['affid']);
        }
        if (isset($_GET['subid'])) {
            $request->session()->put('SID', $_GET['subid']);
        }
        if (isset($_GET['trafid'])) {
            $request->session()->put('TID', $_GET['trafid']);
        }
        return view('main.first_step');
    }

    public function selectSign(Request $request) {

        if (Input::get('registration_token')) {
            $user = User::where('registration_token', Input::get('registration_token'))->first();
            if ($user) {
                return view('main.select_sign', ['registration_token' => $user->registration_token, 'user' => $user]);
            }
        }
        return redirect('/');
    }

    public function step2() {
        if (Input::get('registration_token')) {
            $user = User::where('registration_token', Input::get('registration_token'))->first();

            if ($user && Input::get('sign')) {
                $user->sign = Input::get('sign');
                if ($user->save()) {
                    return view('main.step2', ['registration_token' => $user->registration_token, 'user' => $user]);
                }
            }
        }
        return redirect('/');
    }

    public function step3() {
        if (Input::get('registration_token')) {
            $user = User::where('registration_token', Input::get('registration_token'))->first();

            if ($user && Input::get('sex')) {
                $user->sex = Input::get('sex');

                if ($user->save()) {
                    return view('main.step3', ['registration_token' => $user->registration_token, 'user' => $user]);
                }
            }
        }

        return redirect('/');
    }

    public function step4(Request $request) {
        if (Input::get('registration_token')) {
            $user = User::where('registration_token', Input::get('registration_token'))->first();

            if ($user && Input::get('birth_day') && Input::get('birth_month') && Input::get('birth_year')) {

                $user->birth_day = Input::get('birth_day');
                $user->birth_month = Input::get('birth_month');
                $user->birth_year = Input::get('birth_year');

                $validator = Validator::make($user->getAttributes(), $user->getRules());

                $validator->after(function ($validator) use ($request, $user) {
                    if (!Helper::signDatesIsInvalid($request, $user)) {
                        $validator->errors()->add('birth_day', 'Please enter correct date for selected horoscope sign (' . $user->sign . ').');
                    }
                });

                if ($validator->fails()) {
                    return Redirect::back()->withInput(Input::all())->withErrors($validator);
                }

                if ($user->save()) {
                    $states = States::all()->pluck('state', 'state_code');

                    return view('main.step4', ['registration_token' => $user->registration_token, 'states' => $states, 'user' => $user]);
                }
            }
        }

        return redirect('/');
    }

    public function step5() {
        if (Input::get('registration_token')) {
            $user = User::where('registration_token', Input::get('registration_token'))->first();

            if ($user && Input::get('city') && Input::get('state')) {
                $user->state = Input::get('state');
                $user->city = Input::get('city');
                if ($user->save()) {

                    return view('main.step5', ['registration_token' => $user->registration_token, 'user' => $user]);
                }
            }
        }

        return redirect('/');
    }

    public function startNow(Request $request) {
        if (Input::get('registration_token')) {
            $user = User::where('registration_token', Input::get('registration_token'))->first();

            if ($user && Input::get('birth_time')) {
                $user->name = $user->first_name . time();
                $user->birth_time = Input::get('birth_time');
                if ($user->save()) {
                    if ($request->ajax()) {
                        return "success";
                    } else {
                        return view('main.start-now', ['registration_token' => $user->registration_token, 'user' => $user]);
                    }
                }
            }
        }

        return redirect('/');
    }

    public function successPage() {
        if (Input::get('registration_token')) {
            $user = User::where('registration_token', Input::get('registration_token'))->first();
            if ($user) {
                return view('main.success-page', ['registration_token' => $user->registration_token, 'user' => $user]);
            }
        }

        return redirect('/');
    }

    public function accessReport() {
        if (Input::get('registration_token')) {
            $user = User::where('registration_token', Input::get('registration_token'))->first();
            if ($user) {
                if ($user->short_register == 1) {
                    return redirect('/readyMap?registration_token=' . $user->registration_token);
                }
                return view('main.access-report', ['registration_token' => $user->registration_token, 'user' => $user]);
            }
        }

        return redirect('/');
    }

    public function readyMap() {
        if (Input::get('registration_token')) {
            $user = User::where('registration_token', Input::get('registration_token'))->first();
            if ($user) {
                return view('main.ready-map', ['registration_token' => $user->registration_token, 'user' => $user]);
            }
        }

        return redirect('/');
    }

    public function connectingToSpec() {
        if (Input::get('registration_token')) {
            $user = User::where('registration_token', Input::get('registration_token'))->first();
            if ($user) {
                return view('main.connecting-to-spec', ['registration_token' => $user->registration_token, 'user' => $user]);
            }
        }

        return redirect('/');
    }

    public function signUpMapComplete() {
        if (Input::get('registration_token')) {
            $user = User::where('registration_token', Input::get('registration_token'))->first();
            if ($user) {
                //if ($user->short_register == 1) {
                //	return redirect('/checkout?registration_token=' . $user->registration_token);
                //}

                return view('main.sign-up-map-complete', ['registration_token' => $user->registration_token, 'user' => $user]);
            }
        }

        return redirect('/');
    }

    public function checkout(Request $request) {
        if (Input::get('registration_token')) {
            $user = User::where('registration_token', Input::get('registration_token'))->first();
            $user->ip = $request->ip();



            //if ($user && $user->short_register == 1) {
            //	$payment = new PaymentInfo();
            //	return view('main.checkout', ['registration_token' => $user->registration_token, 'user' => $user, 'payment' => $payment]);
            //}

            if ($user && Input::get('email')) {
                $agents = Agent::all();
                $user->agents()->sync($agents->modelKeys());

                $user->first_name = Input::get('first_name');
                $user->last_name = Input::get('last_name');
                $user->email = Input::get('email');
                $validator = Validator::make(Input::all(), $user->getRules());

                if ($validator->fails()) {
                    return view('main.sign-up-map-complete', ['registration_token' => $user->registration_token, 'user' => $user])->withInput(Input::all())->withErrors($validator);
                } else {
                    if ($user->save()) {

                        if ($request->session()->has('soap_response')) {
                            $responce = $request->session()->get('soap_response');

                            if (isset($responce['lead_id']) && isset($responce['member_id'])) {

                                $loc = file_get_contents('https://ipapi.co/' . $user->ip . '/json/');
                                $obj = json_decode($loc);

                                if (isset($obj->latitude) && isset($obj->longitude)) {
                                    $user->lat = $obj->latitude;
                                    $user->lan = $obj->longitude;
                                }
                                $user->minutes_balance = '00:03:00';
                                $user->lead_id = $responce['lead_id'];
                                $user->member_id = $responce['member_id'];
                                $user->save();


                                Mail::send('emails.new-lead', ['user' => $user], function ($message) use ($user) {
                                    $message->to('tech@livecosmos.com');
                                    $message->subject('New lead');
                                });

                                Mail::send('emails.registration', ['user' => $user], function ($message) use ($user) {
                                    $message->to($user->email);
                                    $message->subject('Welcome to Live Cosmos - Personal Astrology Experience');
                                });

                                Auth::login($user);

                                $agent = Agent::where('status', 'Online')->inRandomOrder()->first();
                                if (!$agent) {
                                    $agent = Agent::inRandomOrder()->first();
                                }

                                $room = AgentUser::where('agent_id', $agent->id)->where('user_id', $user->id)->first();

                                if ($_SERVER['HTTP_HOST'] == 'm.livecosmos.com') {
                                    return redirect('https://m.livecosmos.com/dashboard/live-chat/' . $user->id . '#/customers/' . $room->id . '/' . $agent->id . '/' . $user->id)->with('new-user', 'New user created.');
                                } else {
                                    return redirect('/dashboard/live-chat/' . $user->id . '#/customers/' . $room->id . '/' . $agent->id . '/' . $user->id)->with('new-user', 'New user created.');
                                }
                                $request->session()->forget('soap_response');
                            } else {
                                $validator->errors()->add('card_number', $responce['error']);
                                //	return view('main.checkout2', ['registration_token' => $user->registration_token, 'user' => $user, 'payment' => $payment])->withInput(Input::all())->withErrors($validator);
                            }
                        }
                        //	return view('main.checkout', ['registration_token' => $user->registration_token, 'user' => $user, 'payment' => $payment]);
                    }
                }
            }
        }

        return redirect('/');
    }

    public function checkout2(Request $request) {
        if (Input::get('registration_token')) {
            $user = User::where('registration_token', Input::get('registration_token'))->first();
            if ($user) {
                if (!$request->isMethod('post')) {
                    $payment = new PaymentInfo();
                    return view('main.checkout2', ['registration_token' => $user->registration_token, 'user' => $user, 'payment' => $payment]);
                } else {
                    $validator = Validator::make($request->all(), PaymentInfo::$rules);
                    $payment = new PaymentInfo();
                    $payment->fill($request->all());

                    if ($validator->fails()) {
                        return view('main.checkout2', ['registration_token' => $user->registration_token, 'user' => $user, 'payment' => $payment])->withInput($request->all())->withErrors($validator);
                    } else {
                        $payment->user_id = $user->id;
                        $payment->card_name = Input::get('card_name');
                        $payment->card_number = Input::get('card_number');
                        $payment->card_month = Input::get('card_month');
                        $payment->card_year = Input::get('card_year');
                        $payment->card_cvv = Input::get('card_cvv');
                        $payment->zip = Input::get('zip');

                        if ($payment->save()) {
                            $sku = Input::get('optionsRadios');
                            $soap = new Soap();
                            $responce = $soap->processLead($user->toArray(), $payment->toArray(), $sku);

                            //  return view('main.end-flow');
                            if (isset($responce['order_id']) && isset($responce['member_id'])) {

                                $reportGet = Helper::getReport($responce['type'], null, $user->id);
                                if ($reportGet && isset($reportGet->user_id) && isset($reportGet->text)) {

                                    PaymentHistory::saveHistory($user, $responce);



                                    $loc = file_get_contents('https://ipapi.co/' . $user->ip . '/json/');
                                    $obj = json_decode($loc);

                                    if (isset($obj->latitude) && isset($obj->longitude)) {
                                        $user->lat = $obj->latitude;
                                        $user->lan = $obj->longitude;
                                    }
                                    $user->member_id = $responce['member_id'];
                                    $user->minutes_balance = $responce['totalMinutes'];
                                    $user->save();


                                    Mail::send('emails.registration', ['user' => $user], function ($message) use ($user) {
                                        $message->to($user->email);
                                        $message->subject('Welcome to Live Cosmos - Personal Astrology Experience');
                                    });

                                    Auth::login($user);

                                    $agent = Agent::where('status', 'Online')->inRandomOrder()->first();
                                    if (!$agent) {
                                        $agent = Agent::inRandomOrder()->first();
                                    }

                                    $agents = Agent::all();
                                    $user->agents()->sync($agents->modelKeys());

                                    if ($_SERVER['HTTP_HOST'] == 'm.livecosmos.com') {
                                        return redirect('https://m.livecosmos.com/dashboard/show-report/Personal-Astrology-Report')->with('new-user', 'New user created.');
                                    } else {
                                        return redirect('/dashboard/show-report/Personal-Astrology-Report')->with('new-user', 'New user created.');
                                    }
                                } else {
                                    $validator->errors()->add('card_number', $reportGet);
                                    return view('main.checkout2', ['registration_token' => $user->registration_token, 'user' => $user, 'payment' => $payment])->withInput(Input::all())->withErrors($validator);
                                }
                            } else {
                                $validator->errors()->add('card_number', $responce['error']);
                                return view('main.checkout2', ['registration_token' => $user->registration_token, 'user' => $user, 'payment' => $payment])->withInput(Input::all())->withErrors($validator);
                            }
                        } else {
                            return view('main.checkout2', ['registration_token' => $user->registration_token, 'user' => $user, 'payment' => $payment])->withInput(Input::all())->withErrors($validator);
                        }
                    }
                }
            }
        }

        return redirect('/');
    }

    public function dashboardCheckout(Request $request) {
        if (Input::get('registration_token')) {
            $user = User::where('registration_token', Input::get('registration_token'))->first();
            if ($user) {
                $validator = Validator::make(Input::all(), PaymentInfo::$rules);
                $payment = new PaymentInfo();
                $payment->fill(Input::all());

                if ($validator->fails()) {
                    return view('main.checkout', ['registration_token' => $user->registration_token, 'user' => $user, 'payment' => $payment])->withInput(Input::all())->withErrors($validator);
                } else {
                    $payment->user_id = $user->id;
                    $payment->card_name = Input::get('card_name');
                    $payment->card_number = Input::get('card_number');
                    $payment->card_month = Input::get('card_month');
                    $payment->card_year = Input::get('card_year');
                    $payment->card_cvv = Input::get('card_cvv');
                    $payment->zip = Input::get('zip');

                    if ($payment->save()) {
                        $sku = Input::get('optionsRadios');
                        $soap = new Soap();
                        $responce = $soap->processLead($user->toArray(), $payment->toArray(), $sku);

                        //  return view('main.end-flow');
                        if (isset($responce['order_id']) && isset($responce['member_id'])) {



                            $loc = file_get_contents('https://ipapi.co/' . $user->ip . '/json/');
                            $obj = json_decode($loc);

                            if (isset($obj->latitude) && isset($obj->longitude)) {
                                $user->lat = $obj->latitude;
                                $user->lan = $obj->longitude;
                            }
                            $user->member_id = $responce['member_id'];
                            $user->minutes_balance = $responce['totalMinutes'];
                            $user->save();

                            $paymentHistory = new PaymentHistory();
                            $paymentHistory->user_id = $user->id;
                            $paymentHistory->member_id = $user->member_id;
                            $paymentHistory->lead_id = $user->lead_id;
                            $paymentHistory->payment_info_id = $payment->id;
                            $paymentHistory->type = $responce['type'];
                            $paymentHistory->description = $responce['description'];
                            $paymentHistory->total_minutes = $responce['totalMinutes'];
                            $paymentHistory->order_id = $responce['order_id'];
                            $paymentHistory->total = $responce['total'];
                            $paymentHistory->subtotal = $responce['subtotal'];
                            $paymentHistory->discount = $responce['discount'];
                            $paymentHistory->save();

                            Mail::send('emails.registration', ['user' => $user], function ($message) use ($user) {
                                $message->to($user->email);
                                $message->subject('Welcome to Live Cosmos - Personal Astrology Experience');
                            });

                            Auth::login($user);

                            $agent = Agent::where('status', 'Online')->inRandomOrder()->first();
                            if (!$agent) {
                                $agent = Agent::inRandomOrder()->first();
                            }

                            $agents = Agent::all();
                            $user->agents()->sync($agents->modelKeys());

                            $room = AgentUser::where('agent_id', $agent->id)->where('user_id', $user->id)->first();
                        } else {
                            $validator->errors()->add('card_number', $responce['error']);
                            return view('main.checkout', ['registration_token' => $user->registration_token, 'user' => $user, 'payment' => $payment])->withInput(Input::all())->withErrors($validator);
                        }
                        if ($_SERVER['HTTP_HOST'] == 'm.livecosmos.com') {
                            return redirect('https://m.livecosmos.com/dashboard/live-chat/' . $user->id . '#/customers/' . $room->id . '/' . $agent->id . '/' . $user->id)->with('new-user', 'New user created.');
                        } else {
                            return redirect('/dashboard/live-chat/' . $user->id . '#/customers/' . $room->id . '/' . $agent->id . '/' . $user->id)->with('new-user', 'New user created.');
                        }
                    } else {
                        return view('main.checkout', ['registration_token' => $user->registration_token, 'user' => $user, 'payment' => $payment])->withInput(Input::all())->withErrors($validator);
                    }
                }
            }
        }

        return redirect('/');
    }

    public function sendContact(Request $request) {
        Mail::send('emails.contact-support', ['request' => $request], function ($message) use ($request) {
            $message->from($request->get('email'));
            $message->to('hello@livecosmos.com');
            $message->subject('Message from user');
        });

        return response()->json(['responseText' => 'success'], 200);
    }

    public function sendContactJoinAdvisor(Request $request) {
        Mail::send('emails.contact-join-advisor', ['request' => $request], function ($message) use ($request) {
            $message->from($request->get('email'));
            $message->to('hello@livecosmos.com');
            $message->subject('User wants to join as advisor');
        });

        return response()->json(['responseText' => 'success'], 200);
    }

}
