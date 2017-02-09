@extends('layouts.static')

@section('content')

    <div class="top-container">
        <h2 class="footer-page-headline">
            <div class="container">
                <div class="col col-sm-offset-2 col-sm-10">CONTACT US</div>
            </div>
        </h2>
    </div>
    <div class="container">
        <div class="col col-sm-3 col-md-2">
            <div class="side-links-menu">
                <ul class="list-unstyled clearfix">
                    <li><a href="{{ url('privacy') }}">Privacy</a></li>
                    <li><a href="{{ url('terms') }}">Terms</a></li>
                    <li class="active"><a href="{{ url('contact') }}">Contact</a></li>
                    <li><a href="{{ url('join') }}">Join as Advisor</a></li>
                </ul>
            </div>
        </div>
        <div class="col col-sm-9 col-md-10">
            <div class="bottom-container">
                <div class="contact-block clearfix">
                    <div class="headline">Please contact us at 1-866-994-5907 for any questions you may have!</div>
                    <div class="address">228 Hamilton Avenue<br/>3rd Floor<br/>Palo Alto, CA 94301</div>
                    {!! Form::open(['route' => ['user.contact-support'],'class'=> 'form', 'id'=>'contact_support']) !!}
                    <div class="form-group">
                        <input type="text" class="form-control input-lg" name="name" required placeholder="Name*"/>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control input-lg" name="email" required placeholder="Email*"/>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" rows="7" name="message" required
                                  placeholder="Your Message*"></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" id="contact_support_button"
                                class="btn btn-success btn-green btn-lg btn-submit pull-right">Send
                        </button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

@endsection