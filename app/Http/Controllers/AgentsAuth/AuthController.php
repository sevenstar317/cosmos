<?php

namespace App\Http\Controllers\AgentsAuth;

use App\Models\Agent;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Input;
use Auth;
use Illuminate\Http\Request;

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
    public $uploadedimage;
    protected $redirectTo = '/chat-advisor/first-redirect';

    protected $redirectAfterLogout = '/chat-advisor/login';

  //  protected $loginPath = '/chat-advisor/login';

    protected $guard = 'agent';


    public function showLoginForm()
    {if (Auth::guard('agent')->check())
    {
        return redirect( '/chat-advisor/first-redirect');
    }
        if (view()->exists('auth.authenticate')) {
            return view('auth.authenticate');
        }

        return view('agent.auth.login');
    }
    public function showRegistrationForm()
    {
        return view('agent.auth.register');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        return $this->login($request);
    }

    public function logout(){
        Auth::guard('agent')->logout();
        return redirect('/chat-advisor/login');
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
            'email' => 'required|email|max:255|unique:agents',
            'password' => 'required|min:6|confirmed',
            'zip' => 'max:10',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'speciality_1' => 'required|max:255',
            'speciality_2' => 'required|max:255'
            ,'speciality_3' => 'required|max:255'
            ,'speciality_4' => 'required|max:255'
            ,'speciality_5' => 'required|max:255',
            'image' => 'max:255',
            'uploadedimage'  => 'image|required|max:2000|mimes:jpeg,png'
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
        $destinationPath = 'uploads'; // upload path
        $extension = Input::file('uploadedimage')->getClientOriginalExtension(); // getting image extension

        $model = Agent::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'speciality_2' => $data['speciality_2'],
            'speciality_1' => $data['speciality_1'],
            'speciality_3' => $data['speciality_3'],
            'speciality_4' => $data['speciality_4'],
            'speciality_5' => $data['speciality_5'],
            'password' => bcrypt($data['password']),
        ]);

        $fileName = 'image_'.$model->id.'.'.$extension;
        Input::file('uploadedimage')->move($destinationPath, $fileName);

        $model->image = $fileName;
        $model->save();
        return $model;
    }



}
