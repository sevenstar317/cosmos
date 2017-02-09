<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function about()
    {
        return view('static.about');
    }

    public function privacy()
    {
        return view('static.privacy');
    }

    public function terms()
    {
        return view('static.terms');
    }

    public function faq()
    {
        return view('static.faq');
    }

    public function contact()
    {
        return view('static.contact');
    }

    public function joinAsAdvisor()
    {
        return view('static.join');
    }

    public function sendEmail(){
        Mail::send('emails.registration', [], function ($message)  {
            $message->to('sercul@gmail.com');
            $message->subject('Welcome to Live Cosmos - Personal Astrology Experience');
        });
    }
}
