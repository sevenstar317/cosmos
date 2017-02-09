@extends('layouts.agents_login')

@section('content')
    <div class="auth-container">
        <div class="clearfix auth-block">
            <div class="col col-xs-4 tabs-list no-padding">
                <!-- Nav tabs -->
                <ul class="nav" role="tablist">
                    <li role="presentation">
                        <a href="{{ url('/chat-advisor/login') }}" aria-controls="login">log in</a>
                    </li>
                    <li role="presentation" class="active">
                        <a href="{{ url('/chat-advisor/register') }}" aria-controls="register">register</a>
                    </li>
                    <li role="presentation">
                        <a href="{{ url('/chat-advisor/password/email') }}" aria-controls="forgotmypassport">forgot my
                            passport</a>
                    </li>
                    <li role="presentation">
                        <a href="#" aria-controls="resetpassword">reset password</a>
                    </li>
                </ul>
            </div>
            <div class="col col-xs-8 panes-list">
                <!-- Tab panes -->
                <div role="tabpanel" class="tab-pane fade  in active" id="register">
                    <form class="form-horizontal" enctype="multipart/form-data" role="form" method="POST" action="{{ url('/chat-advisor/register') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                            <div class="input-group">
                                <div class="input-group-addon">first name</div>
                                <input type="text" value="{{ old('first_name') }}" name="first_name"
                                       class="form-control"/>
                            </div>
                            @if ($errors->has('first_name'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                            <div class="input-group">
                                <div class="input-group-addon">last name</div>
                                <input type="text" value="{{ old('last_name') }}" name="last_name"
                                       class="form-control"/>
                            </div>
                            @if ($errors->has('last_name'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <div class="input-group">
                                <div class="input-group-addon">user name</div>
                                <input type="text" value="{{ old('name') }}" name="name" class="form-control"/>
                            </div>
                            @if ($errors->has('name'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif
                        </div>


                        <div class="form-group{{ $errors->has('speciality_1') ? ' has-error' : '' }}">
                            <div class="input-group">
                                <div class="input-group-addon">Speciality 1</div>
                                {!! Form::select('speciality_1', \App\Helpers\Helper::getSigns(), null, ['class' => 'form-control']) !!}
                            </div>
                            @if ($errors->has('speciality_1'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('speciality_1') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('speciality_2') ? ' has-error' : '' }}">
                            <div class="input-group">
                                <div class="input-group-addon">Speciality 2</div>
                                {!! Form::select('speciality_2', \App\Helpers\Helper::getSigns(), null, ['class' => 'form-control']) !!}
                            </div>
                            @if ($errors->has('speciality_2'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('speciality_2') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('speciality_3') ? ' has-error' : '' }}">
                            <div class="input-group">
                                <div class="input-group-addon">Speciality 3</div>
                                {!! Form::select('speciality_3', \App\Helpers\Helper::getSigns(), null, ['class' => 'form-control']) !!}
                            </div>
                            @if ($errors->has('speciality_3'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('speciality_3') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('speciality_4') ? ' has-error' : '' }}">
                            <div class="input-group">
                                <div class="input-group-addon">Speciality 4</div>
                                {!! Form::select('speciality_4', \App\Helpers\Helper::getSigns(), null, ['class' => 'form-control']) !!}
                            </div>
                            @if ($errors->has('speciality_4'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('speciality_4') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('speciality_5') ? ' has-error' : '' }}">
                            <div class="input-group">
                                <div class="input-group-addon">Speciality 5</div>
                                {!! Form::select('speciality_5', \App\Helpers\Helper::getSigns(), null, ['class' => 'form-control']) !!}
                            </div>
                            @if ($errors->has('speciality_5'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('speciality_5') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="input-group">
                                <div class="input-group-addon">email</div>
                                <input type="email" value="{{ old('email') }}" name="email" class="form-control"/>
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
                                <input type="password" name="password" id="password" class="form-control"/>
                            </div>
                            @if ($errors->has('password'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <div class="input-group">
                                <div class="input-group-addon">password confirmation</div>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                       class="form-control"/>
                            </div>
                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('uploadedimage') ? ' has-error' : '' }}">
                            <div class="input-group">
                                <div class="input-group-addon">image</div>
                                <input type="file" value="{{ old('uploadedimage') }}" name="uploadedimage" class="form-control"/>
                            </div>
                            @if ($errors->has('uploadedimage'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('uploadedimage') }}</strong>
                                    </span>
                            @endif
                        </div>


                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary btn-blue">submit</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
