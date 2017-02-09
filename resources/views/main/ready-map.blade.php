@extends('layouts.app')

@section('content')
    <section class="hero-section map-ready-section">
        <div class="container">
            <div class="header">
                <div class="clearfix">
                    {{ Form::hidden('registration_token', $registration_token,['id'=>'registration_token']) }}
                    <div class="col col-sm-2 col-md-3 no-padding-right-sm">
                        <p>Your Map and Chat Advisor are <b>Matched</b>!</p>
                    </div>
                    <div class="col col-sm-10 col-md-9">
                        <div class="table-wrapper">
                            <table class="table hidden-xs">
                                <thead>
                                <tr>
                                    <td class="col col-sm-3">Name</td>
                                    <td class="col col-sm-2">DOB</td>
                                    <td class="col col-sm-2">Horoscope</td>
                                    <td class="col col-sm-2">Gender</td>
                                    <td class="col col-sm-3">City of Birth</td>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="tbody">
                            <div class="tr clearfix">
                                <div class="td col col-sm-3 name">{{ $user->first_name }} {{ $user->last_name }}</div>
                                <div class="td col col-sm-2 dob">
                                    <div class="visible-xs-inline-block">Date of Birth: </div>{{ $user->monthNumber() }}/{{ $user->birth_day }}/{{ $user->birth_year }}
                                </div>
                                <div class="td col col-sm-2 horoscope">
                                    <div class="visible-xs-inline-block">Horoscope: </div>{{ $user->sign }}
                                </div>
                                <div class="td col col-sm-2 gender">
                                    <div class="visible-xs-inline-block">Gender: </div>{{ $user->sex }}
                                </div>
                                <div class="td col col-sm-3 city-birth">
                                    <div class="visible-xs-inline-block">City of Birth: </div>{{ $user->city }}, {{ $user->state }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section-inner">
                <div class="row">
                    <div class="col col-sm-6">
                        <div class="column column-left">
                            <h3 class="topline">Gain Insights on:</h3>
                            <div class="row">
                                <ul class="col col-xs-6 col-sm-5 list-unstyled">
                                    <li><img src="./images/blue-star.png" alt=""> Love</li>
                                    <li><img src="./images/blue-star.png" alt=""> Money</li>
                                    <li><img src="./images/blue-star.png" alt=""> Direction</li>
                                </ul>
                                <ul class="col col-xs-6 col-sm-5 list-unstyled">
                                    <li><img src="./images/blue-star.png" alt=""> Relationship</li>
                                    <li><img src="./images/blue-star.png" alt=""> Health</li>
                                    <li><img src="./images/blue-star.png" alt=""> Much More!</li>
                                </ul>
                            </div>
                            <div class="secure-icons">
                                <img src="./images/secure-icon-1.png" alt=""/>
                                <img src="./images/secure-icon-2.png" alt=""/>
                                <img src="./images/secure-icon-3.png" alt=""/>
                                <img src="./images/secure-icon-4.png" alt=""/>
                            </div>
                        </div>
                    </div>
                    <div class="col col-sm-6">
                        <div class="column column-right" id="confirm_question">
                            <h2 class="topline text-center">
                                <i class="fa fa-exclamation-circle"></i>
                                <span>Are you 18 years old or older?</span>
                            </h2>
                            <div class="text-center">
                                <a href="{{route('connectingToSpec',['registration_token' => $registration_token])}}" class="btn btn-success btn-lg">Yes</a>
                                <a href="{{route('connectingToSpec',['registration_token' => $registration_token])}}" class="btn btn-danger btn-lg">No</a>
                            </div>
                        </div>
                        <div class="column column-right" id="confirm_question_second">
                            <h2 class="topline text-center">
                                <i class="fa fa-exclamation-circle"></i>
                                <span>This Map Reading is for Yourself? </span>
                            </h2>
                            <div class="text-center">
                                <a href="{{route('connectingToSpec',['registration_token' => $registration_token])}}" class="btn btn-success btn-lg">Yes</a>
                                <a href="{{route('connectingToSpec',['registration_token' => $registration_token])}}" class="btn btn-danger btn-lg">No</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection