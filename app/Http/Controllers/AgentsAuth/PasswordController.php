<?php

namespace App\Http\Controllers\AgentsAuth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    protected $guard = 'agent'; //For guard
    protected $broker = 'agents'; //For letting laravel know which config you're going to use for resetting password

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function getEmail()
    {
        return $this->showLinkRequestForm();
    }

    public function showLinkRequestForm()
    {


        if (view()->exists('agent.auth.passwords.email')) {
            return view('agent.auth.passwords.email');
        }

    }

    public function showResetForm(Request $request, $token = null)
    {

        if (is_null($token)) {
            return $this->getEmail();
        }
        $email = $request->input('email');

        if (property_exists($this, 'resetView')) {
            return view($this->resetView)->with(compact('token', 'email'));
        }

        if (view()->exists('agent.auth.passwords.reset')) {
            return view('agent.auth.passwords.reset')->with(compact('token', 'email'));
        }

        return view('agent.auth.passwords.auth.reset')->with(compact('token', 'email'));
    }
}
