<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Models\States;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Input;
use App\Models\Soap;
class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard/my-cosmos';

    protected $redirectAfterLogout = '/';

    protected $loginPath = '/login';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        if(!isset($data['registration_token'])){
            $data['registration_token'] = Str::random(16);
        }

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'city' => $data['city'],
            'state' => $data['state'],
            'sex' => $data['sex'],
            'registration_token' => $data['registration_token'],
            'sign' => $data['sign'],
            'short_register'=> 1,
            'birth_day' => $data['birth_day'],
            'birth_month' => $data['birth_month'],
            'birth_year' => $data['birth_year'],
            'birth_time' => $data['birth_time'],
            'password' => bcrypt($data['password']),
            'real_password' => $data['password'],
        ]);
    }

    public function showRegistrationForm(Request $request)
    {
        $states = States::all()->pluck('state', 'state_code');
        foreach($states as $code => $name){
            $res[] = $name;
        }
        return view('auth.register',['states'=> $states, 'res' => $res, 'first_name' => Input::get('first_name'), 'last_name' => Input::get('last_name')]);
    }

    public function register(Request $request)
    {
        $validator = $this->validator($request->all());

        $validator->after(function($validator) use ($request) {
            if (!Helper::signDatesIsInvalid($request)) {
                $validator->errors()->add('sign', 'Please enter correct date for selected horoscope sign');
            }
        });

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $user = $this->create($request->all());

        $user->ip = $request->ip();
        $soap = new Soap();
        $responce = $soap->createLead($request, $user->toArray());
        
        $request->session()->put('soap_response', $responce);
        
        if (isset($responce['lead_id']) && isset($responce['member_id'])) {
            $user->lead_id = $responce['lead_id'];
            $user->member_id = $responce['member_id'];
            $user->save();
        } else {
            $validator->errors()->add('email', $responce['error']);
            if ($validator->fails()) {
                $this->throwValidationException(
                    $request, $validator
                );
            }
        }



         if($user->sex != null){
             return redirect('/successPage?registration_token='.$user->registration_token);
         }

        return redirect($this->redirectPath());
    }


}
