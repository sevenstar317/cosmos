@extends('layouts.dashboard')

<?php use Collective\Html\FormFacade as Form; ?>

@section('content')
    <div class="clearfix livechat-container">

        @include('layouts._dashboard_left_menu_for_report')

        <div class="col col-sm-10 livechat-content">
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane my-cosmos-tab text-center  active" id="my-cosmos">
                    <?php
                    $natalReport = $user->getNatalReport();
                    if($natalReport && $type == 'natal'): ?>
                    <div class="my-cosmos-headline text-center">
                        <h3 class="my-cosmos-title">PERSONAL ASTROLOGY MAP REPORT</h3>
                        <h4 class="my-cosmos-subtitle">GENERATED ON: {{$natalReport->created_at }}  </h4>
                    </div>
                    <div class="inner-pane-padding">
                        <div class="download-links">
                            <ul class="list-inline list-unstyled">
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
                            <ul class="list-inline list-unstyled">
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
                            <ul class="list-inline list-unstyled">
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
                            <ul class="list-unstyled">
                                <li class="clearfix">
                                    <div class="clearfix img-wrapper">
                                        <img class="img-responsive" src="/images/redirect-link-1.png" alt=""/>
                                    </div>
                                    <p class="pull-left">ASK A CHAT ADVISOR ABOUT YOUR REPORT</p>
                                    <a href="/dashboard/live-chat" target="_blank" style="width: 150px;"
                                       class="btn btn-green btn-success btn-lg pull-right">
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