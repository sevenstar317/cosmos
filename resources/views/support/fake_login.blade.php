@extends('layouts.support')

@section('content')
    <section class="">
        <div class="container">
            <div class="login-form-wrapper">
                <h2 class="headline text-center">log in to Customer Support</h2>
                <div class="login-inner">
                    <form method="POST" action="{{ url('/customer-support/login') }}">
                        {!! csrf_field() !!}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <input type="text" name="email" value="" autocomplete="off" id="435435" class="form-control input-lg" placeholder="Login"/>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <input type="password" name="password"  autocomplete="off"  id="pa33ssword8888" class="form-control input-lg" placeholder="Password"/>
                            @if ($errors->has('password'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif

                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-block btn-lg btn-green">Log In</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection