@extends('layouts.app')

@section('content')
    <section class="hero-section login-section">
        <div class="container">
            <div class="login-form-wrapper">
                <h2 class="headline text-center">log in to Live Cosmos</h2>
                <div class="login-inner">
                    <form method="POST" action="{{ url('/login') }}">
                        {!! csrf_field() !!}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control input-lg" placeholder="Email"/>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password"/>
                            @if ($errors->has('password'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif

                            <a class="text-success" href="{{ url('/password/reset') }}">*Forgot your password?</a>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-block btn-lg btn-green">Log In</button>
                            <a href="{{ url('/register') }}" class="btn btn-block btn-link text-center btn-create">Create an account</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection