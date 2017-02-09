@extends('layouts.app')

@section('content')
<?php use Illuminate\Support\Facades\Input;?>
    <section class="hero-section signup-section">
        <div class="container">
            <div class="signup-form-wrapper">
                <h2 class="headline text-center">Sign Up to Live Cosmos</h2>

                <div class="signup-inner">
                    <form class="signup-form" role="form" method="POST" autocomplete="off" action="{{ url('/register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <input id="email" type="email" class="form-control input-lg" required name="email"
                                   placeholder="Email" value="{{ old('email') }}">

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                            <input id="first_name" required type="text" class="form-control input-lg" name="first_name"
                                   placeholder="First Name" value="{{ Input::has('first_name')? Input::get('first_name'): old('first_name') }}">

                            @if ($errors->has('first_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('first_name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                            <input id="last_name" required type="text" class="form-control input-lg" name="last_name"
                                   placeholder="Last Name" value="{{ Input::has('last_name')? Input::get('last_name'): old('last_name')  }}">

                            @if ($errors->has('last_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('sign') ? ' has-error' : '' }}">
                            {!! Form::select('sign', \App\Helpers\Helper::getSigns(), null, ['class' => 'form-control input-lg','placeholder' => 'Select Your Horoscope Sign', 'required'=>'required']) !!}
                            @if ($errors->has('sign'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('sign') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('sex') ? ' has-error' : '' }}">
                            {!! Form::select('sex', ['Male'=>'Male','Female'=>'Female'], null, ['class' => 'form-control input-lg','placeholder' => 'Select Your Gender', 'required'=>'required']) !!}
                            @if ($errors->has('sex'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('sex') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="row form-group{{ $errors->has('birth_day') ? ' has-error' : '' }}">
                            <div class="col-md-3" style="margin-bottom: 15px;">
                                <select class="form-control input-lg" name="birth_day" id="birth_day">
                                    @for($i = 1; $i < 32; $i++)
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-5" style="margin-bottom: 15px;">
                                <select class="form-control input-lg" name="birth_month" id="birth_month">
                                    <option value="January">January</option>
                                    <option value="February">February</option>
                                    <option value="March">March</option>
                                    <option value="April">April</option>
                                    <option value="May">May</option>
                                    <option value="June">June</option>
                                    <option value="July">July</option>
                                    <option value="August">August</option>
                                    <option value="September">September</option>
                                    <option value="October">October</option>
                                    <option value="November">November</option>
                                    <option value="December">December</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select class="form-control input-lg" name="birth_year" id="birth_year">
                                    @for($i = 1998; $i >= 1930; $i--)
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('birth_time') ? ' has-error' : '' }}">
                            <select required class=' form-control input-lg' name="birth_time" id="birth_time">
                                <option value="">Select Your Birth Time</option>
                                <option value="Sunrise Map">Sunrise Map</option>
                                @for($i = 1; $i < 25; $i++)
                                    <option value="{{$i}}:00">{{$i}}:00</option>
                                @endfor
                            </select>
                        </div>

                        <div class="row form-group{{ $errors->has('state') ? ' has-error' : '' }}">
                            <div class="col-md-6" style="margin-bottom: 15px;">
                                <input autocomplete="off" type="text" placeholder="State" data-provide="typeahead"  class="form-control input-lg" name="state" id="state" />
                            </div>
                            <div class="col-md-6">
                                <input autocomplete="off" type="text" placeholder="City" data-provide="typeahead"  class="form-control input-lg" name="city" id="city" />
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <input id="password" type="password" class="form-control input-lg" placeholder="Password"
                                   name="password">

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <input id="password-confirm" type="password" class="form-control input-lg"
                                   placeholder="Confirm Password" name="password_confirmation">

                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                            @endif
                        </div>


                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <input id="name" type="text" class="form-control input-lg" name="name"
                                   placeholder="Screen Name" value="{{ old('name') }}">

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
                                <input type="checkbox" required/>  I have read and agree to the Live Cosmos member terms
                                and conditions.
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

    <div class="modal fade" id="request-processing-modal-id" tabindex="-1" role="dialog" aria-labelledby="registration-processing-modal-label">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h3><img src="./images/loading.png" alt=""/> Processing Your Request</h3>
                    <h4>Please Wait...</h4>
                </div>
                <div class="modal-footer">
                    <div class="progress-wrapper" style="margin-top: 20px;">
                        <div class="clearfix">
                            <div class="pull-left time-remaining secured-connection"><i class="fa fa-lock"></i> Secured Connection</div>
                            <div class="pull-right time-remaining"><span>Time Remaining:</span> 00:00:<span id="timer">10</span></div>
                        </div>
                        <div id="connectionProgressId" class="progress" >
                            <div class="progress-bar" id="connectionProgressBar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
