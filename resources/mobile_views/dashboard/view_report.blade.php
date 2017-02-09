@extends('layouts.dashboard_mobile')

@section('content')
    <div class="website-content">
        <div class="breadcrumbs">
            <ul class="list-unstyled list-inline">
                <li><a href="/dashboard/initial"><i class="fa fa-chevron-left" aria-hidden="true"></i> My Cosmos</a></li>
            </ul>
        </div>
                    <div class="my-cosmos-headline text-center">
                        <h3 class="my-cosmos-title">PERSONAL ASTROLOGY MAP REPORT</h3>
                        <h4 class="my-cosmos-subtitle">GENERATED ON: {{$report->created_at }}  </h4>
                    </div>
                    <div class="inner-pane-padding">
                        <div class="download-links">
                            <ul class="list-inline list-unstyled text-center">
                                <li>
                                    <a id="download_report" data-id="{{$report->id}}" href="">
                                        <img src="/images/download-icon-1.png" alt=""/>
                                        <span>Download<br/>PDF</span>
                                    </a>
                                </li>
                                <li>
                                    <a id="email_report" data-id="{{$report->id}}" href="">
                                        <img src="/images/download-icon-2.png" alt=""/>
                                        <span>Email<br/>Report</span>
                                    </a>
                                </li>
                                <li>
                                    <a id="new_report"  href="{{action('DashboardController@fillNormal',['sku'=>$report->type=='natal'?'521630':'521632'])}}">
                                        <img src="/images/Email_Report_c.png" alt=""/>
                                        <span>Generate<br/>New Report</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="my-map-descr">
                            <?php

                            echo $report->text;

                            ?>
                        </div>
                    </div>
        <div class="clearfix cosmos-redirect-links">
            <ul class="list-unstyled text-center">
                <li class="clearfix">
                    <div class="clearfix img-wrapper">
                        <img class="img-responsive" src="/images/redirect-link-1.png" alt=""/>
                    </div>
                    <p >ASK A CHAT ADVISOR ABOUT YOUR REPORT</p>
                    <a href="/dashboard/live-chat" target="_blank" style="width: 150px;"
                       class="btn btn-green btn-success btn-lg ">
                        Ask Now
                    </a>
                </li>
            </ul>
        </div>
                </div>
            </div>
        </div>
    </div>
@endsection