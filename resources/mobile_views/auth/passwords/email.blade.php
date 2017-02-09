@extends('layouts.app')

<!-- Main Content -->
@section('content')
    <section class="hero-section login-section">
        <div class="container">
            <div class="login-form-wrapper">
                <h2 class="headline text-center">Reset Passwor</h2>
                <div class="login-inner">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form  role="form" method="POST" action="{{ url('/password/email') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control input-lg" placeholder="Email"/>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-block btn-lg btn-green">Send Password Reset Link</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</section>
@endsection
