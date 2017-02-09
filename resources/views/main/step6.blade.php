@extends('layouts.app')

@section('content')
    <section class="hero-section flow-section select-sign">
        <div class="container">
            <div class="flow-inner text-center">
                <ul class="steps-list list-inline list-unstyled">
                    <li>{{ $user->sign }}</li>
                    <li>{{ $user->sex }}</li>
                    <li>{{ $user->birth_month }} {{ $user->birth_day }}, {{ $user->birth_year }}</li>
                    <li>{{ $user->city }}, {{ $user->state }}</li>
                    <li>{{ $user->birth_time }}</li>
                </ul>
                <p class="flow-title">Enter first name & last name</p>
                <form class="form" action="{{ action('MainController@startNow') }}">
                    {{ Form::hidden('registration_token', $registration_token,['id'=>'registration_token']) }}
                    <div class="form-group">
                        <input type="text" required class="form-control" name="first_name" id="first_name"  placeholder="First Name"/>
                        <input type="text" required class="form-control" name="last_name" id="last_name" placeholder="Last Name"/>
                    </div>
                    <div class="form-group">
                        <button type="submit"  class="btn btn-success btn-lg btn-green btn-flow">start now</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal fade" id="request-processing-modal-id" tabindex="-1" role="dialog" aria-labelledby="request-processing-modal-label">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <h3><img src="./images/loading.png" alt=""/> Processing Your Request</h3>
                        <h4>Please Be Patient...</h4>
                    </div>
                    <div class="modal-footer">
                        <div class="progress-wrapper" style="margin-top: 20px;">
                            <div class="clearfix">
                                <div class="pull-left time-remaining secured-connection"><i class="fa fa-lock"></i> Secured Connection</div>
                                <div class="pull-right time-remaining"><span>Time Remaining:</span> 00:00:<span id="timer">10</span></div>
                            </div>
                            <div id="connectionProgressId" class="progress" >
                                <div class="progress-bar" id="connectionProgressBar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" ></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection