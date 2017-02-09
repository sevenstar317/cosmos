@extends('layouts.app')

@section('content')
    <section class="hero-section success-section">
        <div class="container">

            <ul class="steps-list text-center list-inline list-unstyled">
                <li>{{ $user->sign }}</li>
                <li>{{ $user->sex }}</li>
                <li>{{ $user->birth_month }} {{ $user->birth_day }}, {{ $user->birth_year }}</li>
                <li>{{ $user->city }}, {{ $user->state }}</li>
                <li>{{ $user->birth_time }}</li>
                <li>{{ $user->first_name }} {{ $user->last_name }}</li>
                <li class="update"><a href="/selectSign" class="btn btn-success btn-green">Update</a></li>
            </ul>

            <div class="section-inner success-page-click" data-token="{{$user->registration_token}}" role="button">
                <div class="headline text-center">
                    <h1><span>Success:</span> Your Cosmos Map for <span style="text-transform: capitalize">{{ $user->first_name }} {{ $user->last_name }}</span> is Ready for Live Chat & Life Analysis</h1>
                    <p>Results and Data Last Updated {{date('m/d/Y')}}</p>
                </div>
                <div class="subline text-center">
                    <span>NEXT STEP:</span> Download and access live astrology and cosmos report by clicking "Connect" button.<br/>You can modify your search at the top of the page.
                    <div>
                        <img src="./images/secure-image-2.png" alt=""/>
                        <img src="./images/secure-image-1.png" alt=""/>
                    </div>
                </div>

                <div class="table-wrapper">
                    <table class="table hidden-xs hidden-sm">
                        <thead>
                        <tr>
                            <td class="col col-md-2">Name</td>
                            <td class="col col-md-1">Gender</td>
                            <td class="col col-md-2">DOB</td>
                            <td class="col col-md-2">Horoscope</td>
                            <td class="col col-md-1">TOB</td>
                            <td class="col col-md-2">City of Birth</td>
                            <td class="col col-md-2">Full Report</td>
                        </tr>
                        </thead>
                    </table>
                    <div class="tbody">
                        <div class="tr clearfix">
                            <div class="td col col-md-2 name">{{ $user->first_name }} {{ $user->last_name }}</div>
                            <div class="td col col-md-1 gender">
                                <div class="visible-xs-inline-block visible-sm-inline-block">Gender:</div> {{ $user->sex }}
                            </div>
                            <div class="td col col-md-2 dob">
                                <div class="visible-xs-inline-block visible-sm-inline-block">Date of Birth:</div> {{ $user->birth_month }} {{ $user->birth_day }}, {{ $user->birth_year }}
                            </div>
                            <div class="td col col-md-2 horoscope">
                                <div class="visible-xs-inline-block visible-sm-inline-block">Horoscope:</div> {{ $user->sign }}
                            </div>
                            <div class="td col col-md-1 tob">
                                <div class="visible-xs-inline-block visible-sm-inline-block">Time of Birth:</div> {{ $user->birth_time }}
                            </div>
                            <div class="td col col-md-2 city-birth">
                                <div class="visible-xs-inline-block visible-sm-inline-block">City of Birth:</div> {{ $user->city }}, {{ $user->state }}
                            </div>
                            <div class="td col col-md-2 full-report">
                                <div class="text-center small-report-icons">
                                    <img src="./images/report-icon-1.png" alt=""/>
                                    <img src="./images/report-icon-2.png" alt=""/>
                                    <img src="./images/report-icon-3.png" alt=""/>
                                    <img src="./images/report-icon-4.png" alt=""/>
                                    <img src="./images/report-icon-5.png" alt=""/>
                                    <img src="./images/report-icon-6.png" alt=""/>
                                    <a href="{{ action('MainController@accessReport',['registration_token' => $user->registration_token]) }}" class="btn btn-success btn-block btn-green">CONNECT</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection