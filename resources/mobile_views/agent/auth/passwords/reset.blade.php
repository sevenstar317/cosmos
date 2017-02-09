@extends('layouts.agents_login')

@section('content')


    <div class="auth-container">
        <div class="clearfix auth-block">
            <div class="col col-xs-4 tabs-list no-padding">
                <!-- Nav tabs -->
                <ul class="nav" role="tablist">
                    <li role="presentation" >
                        <a href="{{ url('/chat-advisor/login') }}" aria-controls="login" >log in</a>
                    </li>
                    <li role="presentation" >
                        <a href="{{ url('/chat-advisor/register') }}" aria-controls="register" >register</a>
                    </li>
                    <li role="presentation" >
                        <a href="{{ url('/chat-advisor/password/email') }}" aria-controls="forgotmypassport" >forgot my passport</a>
                    </li>
                    <li role="presentation" class="active">
                        <a href="#" aria-controls="resetpassword" >reset password</a>
                    </li>
                </ul>
            </div>
            <div class="col col-xs-8 panes-list">
                     <div role="tabpanel" class="tab-pane fade  in active" id="resetpassword">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/chat-advisor/password/reset') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <div class="input-group">
                                    <div class="input-group-addon">email</div>
                                    <input type="email" class="form-control" name="email" value="{{ $email or old('email') }}"/>
                                </div>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <div class="input-group">
                                    <div class="input-group-addon">password</div>
                                    <input type="password" name="password" class="form-control"/>
                                </div>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <div class="input-group">
                                    <div class="input-group-addon">confirm password</div>
                                    <input name="password_confirmation" type="password" class="form-control"/>
                                </div>
                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary btn-blue">Reset Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection