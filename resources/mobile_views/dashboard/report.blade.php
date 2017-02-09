@extends('layouts.dashboard_mobile')

@section('content')
    <div class="website-content">
        <div class="breadcrumbs">
            <ul class="list-unstyled list-inline">
                <li><a href="/dashboard/initial"><i class="fa fa-chevron-left" aria-hidden="true"></i> My Cosmos</a></li>
            </ul>
        </div>
        <div class="my-cosmos-headline text-center">
            <h3 class="my-cosmos-title">My Personal Information</h3>
        </div>
        <div class="cosmos-comb-summary">
            <ul class="list-inline list-unstyled text-center">
                <li>
                    <div>
                        <img src="/images/cosmos-sum-1.png" alt=""/>
                        <span>{{$user->getFullName()}}</span>
                    </div>
                </li>
                <li>
                    <div>
                        <img src="/images/cosmos-sum-2.png" alt=""/>
                        <span>{{$user->sex}}</span>
                    </div>
                </li>
                <li>
                    <div>
                        <img src="/images/cosmos-sum-3.png" alt=""/>
                        <span>{{$user->getBirthday()}}</span>
                    </div>
                </li>
                <li>
                    <div>
                        <img src="/images/cosmos-sum-4.png" alt=""/>
                        <span>{{$user->sign}}</span>
                    </div>
                </li>
                <li>
                    <div>
                        <img src="/images/cosmos-sum-5.png" alt=""/>
                        <span>{{$user->birth_time}}</span>
                    </div>
                </li>
                <li>
                    <div>
                        <img src="/images/cosmos-sum-6.png" alt=""/>
                        <span>{{ $user->city }}, {{ $user->state }}</span>
                    </div>
                </li>
            </ul>
        </div>
                    <?php
                    $natalReport = $user->getNatalReport();
                    if($natalReport && $type == 'natal'): ?>
                    <div class="my-cosmos-headline text-center">
                        <h3 class="my-cosmos-title">PERSONAL ASTROLOGY MAP REPORT</h3>
                        <h4 class="my-cosmos-subtitle">GENERATED ON: {{$natalReport->created_at }}  </h4>
                    </div>
                    <div class="inner-pane-padding">
                        <div class="download-links">
                            <ul class="list-inline list-unstyled text-center">
                                <li>
                                    <a id="download_report" data-id="{{$natalReport->id}}" href="">
                                        <img src="/images/download-icon-1.png" alt=""/>
                                        <span>Download<br/>PDF</span>
                                    </a>
                                </li>
                                <li>
                                    <a id="email_report" data-id="{{$natalReport->id}}" href="">
                                        <img src="/images/download-icon-2.png" alt=""/>
                                        <span>Email<br/>Report</span>
                                    </a>
                                </li>
                                <li>
                                    <a id="new_report"  href="{{action('DashboardController@fillNormal',['sku'=>'521630'])}}">
                                        <img src="/images/Email_Report_c.png" alt=""/>
                                        <span>Generate<br/>New Report</span>
                                    </a>
                                </li>
                                <!--    <li>
                                <a href="">
                                    <img src="/images/download-icon-3.png" alt=""/>
                                    <span>Monitor<br/>Map Changes</span>
                                </a>
                            </li>
                            !-->
                            </ul>
                        </div>

                        <div class="my-map-descr">
                            <?php

                            echo $natalReport->text;

                            ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php
                    $futureReport = $user->getFutureReport();
                    if($futureReport && $type == 'future'): ?>
                    <div class="my-cosmos-headline text-center">
                        <h3 class="my-cosmos-title">Future Forecast Map Report</h3>
                        <h4 class="my-cosmos-subtitle">GENERATED ON: {{$futureReport->created_at }}  </h4>
                    </div>
                    <div class="inner-pane-padding">
                        <div class="download-links">
                            <ul class="list-inline list-unstyled text-center">
                                <li>
                                    <a id="download_report" data-id="{{$futureReport->id}}" href="">
                                        <img src="/images/download-icon-1.png" alt=""/>
                                        <span>Download<br/>PDF</span>
                                    </a>
                                </li>
                                <li>
                                    <a id="email_report" data-id="{{$futureReport->id}}" href="">
                                        <img src="/images/download-icon-2.png" alt=""/>
                                        <span>Email<br/>Report</span>
                                    </a>
                                </li>
                                <li>
                                    <a id="new_report"  href="{{action('DashboardController@fillNormal',['sku'=>'521632'])}}">
                                        <img src="/images/Email_Report_c.png" alt=""/>
                                        <span>Generate<br/>New Report</span>
                                    </a>
                                </li>
                                <!--    <li>
                               <a href="">
                                   <img src="/images/download-icon-3.png" alt=""/>
                                   <span>Monitor<br/>Map Changes</span>
                               </a>
                           </li>
                           !-->
                            </ul>
                        </div>

                        <div class="my-map-descr">
                            <?php echo $futureReport->text ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php
                        $getRomanticReport = $user->getRomanticReport();
                    if($getRomanticReport && $type == 'relationship'): ?>
                    <div class="my-cosmos-headline text-center">
                        <h3 class="my-cosmos-title">Romantic Map Report</h3>
                        <h4 class="my-cosmos-subtitle">GENERATED ON: {{$getRomanticReport->created_at }}  </h4>
                    </div>
                    <div class="inner-pane-padding">
                        <div class="download-links">
                            <ul class="list-inline list-unstyled text-center">
                                <li>
                                    <a id="download_report" data-id="{{$getRomanticReport->id}}" href="">
                                        <img src="/images/download-icon-1.png" alt=""/>
                                        <span>Download<br/>PDF</span>
                                    </a>
                                </li>
                                <li>
                                    <a id="email_report" data-id="{{$getRomanticReport->id}}" href="">
                                        <img src="/images/download-icon-2.png" alt=""/>
                                        <span>Email<br/>Report</span>
                                    </a>
                                </li>
                                <li>
                                    <a id="new_report"  href="{{action('DashboardController@fillRomantic')}}">
                                        <img src="/images/Email_Report_c.png" alt=""/>
                                        <span>Generate<br/>New Report</span>
                                    </a>
                                </li>
                            <!--    <li>
                                    <a href="">
                                        <img src="/images/download-icon-3.png" alt=""/>
                                        <span>Monitor<br/>Map Changes</span>
                                    </a>
                                </li>
                                !-->
                            </ul>
                        </div>

                        <div class="my-map-descr">
                            <?php echo $getRomanticReport->text ?>
                        </div>
                    </div>
                    <?php endif; ?>
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