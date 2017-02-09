@extends('layouts.app')

@section('content')
    <section class="hero-section signup-section">
        <div class="container">
            <div class="signup-form-wrapper">
                <h2 class="headline text-center">Sign Up to Live Cosmos</h2>
                <div class="signup-inner">
                    <div class="facebook-connect text-center">
                        <a href="">
                            <img src="./images/facebook-connect.png" alt=""/>
                            <p>We will never post to Facebook on your behalf</p>
                        </a>
                    </div>
                    <div class="text-center or">or</div>
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <input id="email" type="email" class="form-control input-lg" name="email" placeholder="Email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <input id="password" type="password" class="form-control input-lg"  placeholder="Password" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <input id="password-confirm" type="password" class="form-control" placeholder="Confirm Password" name="password_confirmation">

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                        </div>


                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <input id="name" type="text" class="form-control input-lg" name="name" placeholder="Screen Name" value="{{ old('name') }}">

                            @if ($errors->has('name'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="checkbox">
                            <label>
                                <input type="checkbox"/> I want to receive special offers, coupons and tips via email.
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox"/> I have read and agree to the Live Cosmos member terms and conditions.
                            </label>
                        </div>
                        <p class="agreement">Your information will be kept completely confidential</p>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-block btn-lg btn-green">Sign Up</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection
