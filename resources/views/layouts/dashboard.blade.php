<!DOCTYPE html>
<html lang="en" ng-app="app">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description"
          content="Live Cosmos provides personalized astrology readings based on your specific name, date of birth, time of birth, location and more! ">
    <meta name="keywords"
          content="Astrology readings, Personalized Astrology Readings, Astrology, Cosmos, Live Cosmos, Tarot Readings, Psychic Readings, Psychic, Tarot, Horoscope readings, horoscope, astrology reading, personal astrology, astrology charts, astrology online, astrology chat, chat astrology, psychic online, tarot online, horoscope online, personal astrology online, astrologist online, psychic medium, check my astrology, check astrology, check horoscope">

    <title>Live Cosmos - Personalized Astrology Readings, Reports & more!</title>


    <link href="{{ elixir('css/style.css') }}" rel="stylesheet">
    <link href="{{ elixir('css/app.css') }}" rel="stylesheet">
    <link href="{{ elixir('css/all.css') }}" rel="stylesheet">

    <script src="{{ elixir('js/all.js') }}"></script>
    <script src="{{elixir('js/custom.min.js')}}"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 10]>
    <script src="./js/html5shiv.js"></script>
    <script src="./js/respond.min.js"></script>
    <![endif]-->
    <script>
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                        (i[r].q = i[r].q || []).push(arguments)
                    }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                    m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-84489439-1', 'auto');
        ga('send', 'pageview');

    </script>
</head>
<body>

<div class="container-fluid main-wrapper">
    <header>
        <div class="container">
            <nav class="navbar" role="navigation">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                data-target="#menu-id">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="logo-link" href="/"><img src="/images/logo.png" class="img-responsive" alt=""/></a>
                    </div>
                    <div class="collapse navbar-collapse" id="menu-id">
                        <ul class="nav navbar-nav navbar-right main-menu">
                            <?php  if(!Auth::guest()): ?>
                            <li class="time-left">
                                <div class="btn btn-sm time">
                                    <i class="fa fa-clock-o"></i> {{Auth::user()->minutes_balance}}
                                </div>
                            </li>
                            <?php endif; ?>
                            <li class="time-add" style="margin-left: 10px;">
                                <button class="btn btn-sm btn-primary time" id="<?php  if (isset(Auth::user()->paymentInfo)) {
                                    echo 'add_funds';
                                } else {
                                    echo 'add_payment_info';
                                } ?>">
                                    <i class="fa fa-plus"></i> Add minutes
                                </button>
                            </li>
                            <?php  if(Auth::guest()): ?>
                            <li><a class="btn btn-sm btn-primary sign-in" href="{{ url('/login') }}">Sign in</a></li>
                            <?php if ($_SERVER['HTTP_HOST'] !== 'trackingcsm.livecosmos.com' && $_SERVER['HTTP_HOST'] !== 'm.livecosmos.com') { ?>
                            <li><a class="btn btn-sm btn-info sign-up" href="{{ url('/register') }}">Register</a></li>
                            <?php }?>
                            <?php else: ?>
                            <li><a class="btn btn-sm btn-primary sign-in" href="{{ url('/logout') }}">Sign out</a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <div class="website-content">
        <section class="hero-section livechat-section clearfix">
            <div class="col col-xs-offset-1 col-xs-10">

                @yield('content')

            </div>
        </section>
    </div>

    <?php  if(!Auth::guest()): ?>
    @include('dashboard.partials._thankyou')
    <?php endif; ?>


</div>

<!-- quickcheckout !-->
<div class="modal fade" id="add-minutes-checkout-modal-id" tabindex="-1" role="dialog" aria-labelledby="personal-map-modal-label">
    <div class="modal-dialog" style="width: 550px" role="document">
        <div class="modal-content text-center">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Time Almost Up. Load Minutes Now!</h4>
            </div>
            <div class="modal-body" style="padding-bottom: 0px;">
                <img src="/images/add-minutes-checkout-pop.png" alt=""/>
                <div class="headline">50% OFF 5 Minute Package Now. Only $2.95!<br/> You Can Always Use Your Minutes!</div>
                <div class="row checkout-top checkout-section" style="padding-bottom: 0px;">
                    <div class="col col-sm-12 ">

                        <div class="column" style="    background-color: rgba(159, 195, 224, 0.8);">
                            <h1 class="heading"><span>Limited Time Offer</span> {{date('m/d/Y')}}: Save 50% Now!</h1>
                            <div class="clearfix checkout-radios-wrapper">
                                <div class="radio radio-1 radio-single active">
                                    <label class="clearfix">
                                        <div class="headline-wrapper">
                                            <input type="radio" checked="">
                                            <h3 class="headline" style="color:white;font-size: 20px;">5 Minutes</h3>
                                        </div>
                                        <div class="clearfix current-price-wrapper">
                                            <p class="current-price" style="    font-size: 28px;    margin-left: 40%;">$2.95</p>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <form action="/tets" method="POST" id="5_minutes_checkout" class="text-left" style="padding: 10px 0 0;">
                    {!! Form::hidden('sku','521634') !!}
                    <div class="clearfix">
                        <div class="col col-sm-5 ">
                            <div class="form-group">
                                <label for="">Name on Card</label>
                                {!! Form::text('card_name',  $user->first_name .' '. $user->last_name , ['class' => 'form-control','required'=>'required']) !!}
                            </div>
                        </div>
                        <div class="col col-sm-2 ">
                            <div class="form-group">
                                <label for="">Exp. Date</label>
                                {{ Form::select('card_month', ['01'=>'01','02'=>'02','03'=>'03','04'=>'04','05'=>'05','06'=>'06','07'=>'07','08'=>'08','09'=>'09','10'=>'10','11'=>'11','12'=>'12'],null,['class'=>'form-control','required'=>'required']) }}
                            </div>
                        </div>
                        <div class="col col-sm-3">
                            <div class="form-group">
                                <label for="">&nbsp;</label>
                                {{ Form::select('card_year', ['2016'=>'2016','2017'=>'2017','2018'=>'2018','2019'=>'2019','2020'=>'2020','2021'=>'2021'],null,['class'=>'form-control','required'=>'required']) }}
                            </div>
                        </div>
                        <div class="col col-sm-2 no-padding-left">
                            <div class="form-group">
                                <label for="">CVV Code</label>
                                {!! Form::text('card_cvv', '', ['class' => 'form-control','required'=>'required']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="clearfix">
                        <div class="col col-sm-5">
                            <div class="form-group">
                                <label for="">Card Number</label>
                                {!! Form::text('card_number', '', ['class' => 'form-control', 'style'=>"color:black;border: 1px solid red;background-color: #f2dede",'required'=>'required']) !!}
                            </div>
                        </div>
                        <div class="col col-sm-3">
                            <div class="form-group">
                                <label for="">Zip/Postal Code</label>
                                {!! Form::text('zip', '', ['class' => 'form-control','required'=>'required']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="clearfix">
                        <div class="col col-xs-12">
                            <img src="/images/visa.png" alt=""/>
                            <img src="/images/mastercard.png" alt=""/>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" id="add_5_minutes_checkout" class="btn btn-primary btn-green btn-lg">continue</button>
                    </div>
                </form>
                <div class="row checkout-top checkout-section" style="padding-bottom: 0px">
                    <div class="col col-sm-12 ">
                        <div class="column" style="    background-color: rgba(159, 195, 224, 0.8);margin-bottom:0px">
                            <div class="info-wrapper">
                                <div class="anonymous-search">All Readings Are <span>Confidential</span>! We Will Never Share your Information with Anyone!
                                </div>
                                <div class="testimonials">
                                    <div class="item">
                                        <span class="author-name">Ashley R.</span>
                                        <span class="author-review">"Live Cosmos is the most reliable and accurate astrology and numerology source online"</span>
                                        <br/>
                                        <img src="/images/green-stars.png" alt=""/>
                                    </div>
                                    <div class="item">
                                        <span class="author-name">Brad C.</span>
                                        <span class="author-review">"I was shocked to see how unaware I was about obstacles that blocked my luck"</span>
                                        <br/>
                                        <img src="/images/green-stars.png" alt=""/>
                                    </div>
                                </div>
                                <div class="secure-icons text-center">
                                    <img src="/images/secure-icon-1.png" alt=""/>
                                    <img src="/images/secure-icon-2.png" alt=""/>
                                    <img src="/images/secure-icon-3.png" alt=""/>
                                    <img src="/images/secure-icon-4.png" alt=""/>
                                </div>
                            </div>

                            <div class="satisfaction-guarantee">
                                <p class="title">100% Satisfaction Guarantee</p>
                                <p>If you ever feel unsatisfied with Live Cosmos, Please give us a call 24 hours a day, 7 days a week! Our representatives are
                                    always ready to help you with any concerns you may have. 1.866.994.5907</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal  add funds-->
<div class="modal fade" id="add-funds-modal-id" tabindex="-1" role="dialog" aria-labelledby="add-funds-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content text-center">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Add Minutes</h4>
            </div>
            <div class="modal-body">
                <img src="/images/add-funds-icon.png" alt=""/>

                <div class="clearfix">
                    <img class="grid-lines" src="/images/grid-lines.png" alt=""/>
                </div>
                <div class="clearfix text-center selectors">
                    <div class="col col-xs-4">
                        <a href="" id="add_5_minutes" class="add-selector">
                            <span class="value">5</span><span class="unity">min</span>
                            <span class="hover">+ ADD</span>
                        </a>
                    </div>
                    <div class="col col-xs-4">
                        <a href="" id="add_10_minutes" class="add-selector">
                            <span class="value">10</span><span class="unity">min</span>
                            <span class="hover">+ ADD</span>
                        </a>
                    </div>
                    <div class="col col-xs-4">
                        <a href="" id="add_15_minutes" class="add-selector">
                            <span class="value">15</span><span class="unity">min</span>
                            <span class="hover">+ ADD</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal email chat-->
<div class="modal fade email-chat-modal-id" id="email-chat-modal-id" tabindex="-1" role="dialog"
     aria-labelledby="email-chat-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content text-center">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Email Chat</h4>
            </div>
            <div class="modal-body">
                <img src="/images/email-chat-icon.png" alt=""/>

                <div class="headline">Email this conversation directly to your email</div>
            </div>
            <div class="modal-subbody">
                <div class="clearfix text-left">
                    <ul class="col col-xs-4 list-unstyled">
                        <li><img src="/images/green-star.png" alt=""/> Love</li>
                        <li><img src="/images/green-star.png" alt=""/> Money</li>
                        <li><img src="/images/green-star.png" alt=""/> Obstacles</li>
                    </ul>
                    <ul class="col col-xs-4 list-unstyled">
                        <li><img src="/images/green-star.png" alt=""/> Relationships</li>
                        <li><img src="/images/green-star.png" alt=""/> Health</li>
                        <li><img src="/images/green-star.png" alt=""/> Direction</li>
                    </ul>
                    <ul class="col col-xs-4 list-unstyled">
                        <li><img src="/images/green-star.png" alt=""/> Career</li>
                        <li><img src="/images/green-star.png" alt=""/> Future</li>
                        <li><img src="/images/green-star.png" alt=""/> More!</li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <a href="" id="email_chat_button" class="btn btn-primary btn-blue btn-lg">send</a>

                <p>You will be charged a one time administrative fee of $2.95 to be receive an email chat copy. No other
                    charges will be made for this service. </p>
            </div>
        </div>
    </div>
</div>

<!-- Modal download chat -->
<div class="modal fade download-chat-modal-id" id="download-chat-modal-id" tabindex="-1" role="dialog"
     aria-labelledby="download-chat-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content text-center">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Download Chat</h4>
            </div>
            <div class="modal-body">
                <img src="/images/download-chat-icon.png" alt=""/>

                <div class="headline">Download a PDF version of this conversation</div>
            </div>
            <div class="modal-subbody">
                <div class="clearfix text-left">
                    <ul class="col col-xs-4 list-unstyled">
                        <li><img src="/images/green-star.png" alt=""/> Love</li>
                        <li><img src="/images/green-star.png" alt=""/> Money</li>
                        <li><img src="/images/green-star.png" alt=""/> Obstacles</li>
                    </ul>
                    <ul class="col col-xs-4 list-unstyled">
                        <li><img src="/images/green-star.png" alt=""/> Relationships</li>
                        <li><img src="/images/green-star.png" alt=""/> Health</li>
                        <li><img src="/images/green-star.png" alt=""/> Direction</li>
                    </ul>
                    <ul class="col col-xs-4 list-unstyled">
                        <li><img src="/images/green-star.png" alt=""/> Career</li>
                        <li><img src="/images/green-star.png" alt=""/> Future</li>
                        <li><img src="/images/green-star.png" alt=""/> More!</li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <a href="" class="btn btn-primary btn-blue btn-lg">send</a>

                <p>You will be charged a one time administrative fee of $2.95 to be able to download PDF chat messages.
                    No other charges will be made for this service and you will be able to use the PDF features as long
                    as you remain an active user.</p>
            </div>
        </div>
    </div>
</div>


<!-- Modal email report-->
<div class="modal fade email-report-modal-id" id="email-chat-modal-id" tabindex="-1" role="dialog"
     aria-labelledby="email-report-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content text-center">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Email Report</h4>
            </div>
            <div class="modal-body">
                <img src="/images/email-chat-icon.png" alt=""/>

                <div class="headline">Email this report directly to your email</div>
            </div>
            <div class="modal-subbody">
                <div class="clearfix text-left">
                    <ul class="col col-xs-4 list-unstyled">
                        <li><img src="/images/green-star.png" alt=""/> Love</li>
                        <li><img src="/images/green-star.png" alt=""/> Money</li>
                        <li><img src="/images/green-star.png" alt=""/> Obstacles</li>
                    </ul>
                    <ul class="col col-xs-4 list-unstyled">
                        <li><img src="/images/green-star.png" alt=""/> Relationships</li>
                        <li><img src="/images/green-star.png" alt=""/> Health</li>
                        <li><img src="/images/green-star.png" alt=""/> Direction</li>
                    </ul>
                    <ul class="col col-xs-4 list-unstyled">
                        <li><img src="/images/green-star.png" alt=""/> Career</li>
                        <li><img src="/images/green-star.png" alt=""/> Future</li>
                        <li><img src="/images/green-star.png" alt=""/> More!</li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <a href="" id="email_report_button" class="btn btn-primary btn-blue btn-lg">send</a>

                <p>
                    You will be charged a one time administrative fee of $4.95 to receive a copy of this report directly
                    to you email. No other charges will be made for this service.
                </p>
            </div>
        </div>
    </div>
</div>


<!-- Modal download report -->
<div class="modal fade download-report-modal-id" id="download-chat-modal-id" tabindex="-1" role="dialog"
     aria-labelledby="download-report-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content text-center">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Download Report</h4>
            </div>
            <div class="modal-body">
                <img src="/images/download-chat-icon.png" alt=""/>

                <div class="headline">Download a PDF version of this report</div>
            </div>
            <div class="modal-subbody">
                <div class="clearfix text-left">
                    <ul class="col col-xs-4 list-unstyled">
                        <li><img src="/images/green-star.png" alt=""/> Love</li>
                        <li><img src="/images/green-star.png" alt=""/> Money</li>
                        <li><img src="/images/green-star.png" alt=""/> Obstacles</li>
                    </ul>
                    <ul class="col col-xs-4 list-unstyled">
                        <li><img src="/images/green-star.png" alt=""/> Relationships</li>
                        <li><img src="/images/green-star.png" alt=""/> Health</li>
                        <li><img src="/images/green-star.png" alt=""/> Direction</li>
                    </ul>
                    <ul class="col col-xs-4 list-unstyled">
                        <li><img src="/images/green-star.png" alt=""/> Career</li>
                        <li><img src="/images/green-star.png" alt=""/> Future</li>
                        <li><img src="/images/green-star.png" alt=""/> More!</li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <a href="" id="download_report_button" class="btn btn-primary btn-blue btn-lg">send</a>

                <p>You will be charged a one time administrative fee of $4.95 to be able to download PDF reports. No
                    other charges will be made for this service and you will be able to use the PDF features as long as
                    you remain an active user.</p>
            </div>
        </div>
    </div>
</div>


<!-- Modal monitor map -->
<div class="modal fade" id="monitor-chat-modal-id" tabindex="-1" role="dialog"
     aria-labelledby="monitor-chat-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content text-center">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Monitor your Cosmos Map!</h4>
            </div>
            <div class="modal-body">
                <div class="clearfix text-left">
                    <div class="col col-sm-7">
                        <img src="/images/monitor-chat-icon.png" alt=""/>

                        <div class="headline">Get Weekly Updates of your Map Directly to your Email</div>
                    </div>
                    <div class="col col-sm-5">
                        <div class="spinner-wrapper">
                            <div class="spinner-animation"></div>
                            <div class="spinner-text">Next Update <span>2.24.16</span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-subbody">
                <div class="clearfix text-left">
                    <ul class="col col-xs-4 list-unstyled">
                        <li><img src="/images/green-star.png" alt=""/> Love</li>
                        <li><img src="/images/green-star.png" alt=""/> Money</li>
                        <li><img src="/images/green-star.png" alt=""/> Obstacles</li>
                    </ul>
                    <ul class="col col-xs-4 list-unstyled">
                        <li><img src="/images/green-star.png" alt=""/> Relationships</li>
                        <li><img src="/images/green-star.png" alt=""/> Health</li>
                        <li><img src="/images/green-star.png" alt=""/> Direction</li>
                    </ul>
                    <ul class="col col-xs-4 list-unstyled">
                        <li><img src="/images/green-star.png" alt=""/> Career</li>
                        <li><img src="/images/green-star.png" alt=""/> Future</li>
                        <li><img src="/images/green-star.png" alt=""/> More!</li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <a href="" class="btn btn-primary btn-blue btn-lg">activate now</a>

                <p>You will be charged a one time administrative fee of $9.95 to receive automated Alerts about your
                    Cosmos Map. No other charges will be made for this service.</p>
            </div>
        </div>
    </div>
</div>

<!-- Personal astro Modal -->
<div class="modal fade" id="personal-map-modal-id" tabindex="-1" role="dialog"
     aria-labelledby="personal-map-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content text-center">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Personal Astrology Map Report</h4>
            </div>
            <div class="modal-body">
                <img src="/images/personal-map-modal.png" alt=""/>

                <div class="headline">Get the most detailed and personal Astrology map analysis available today! Deepen
                    your self-awareness and introspection with your birth chart and other personal information!
                </div>
            </div>
            <div class="modal-footer">
                <a href="" id="buy_natal_report" class="btn btn-success btn-green btn-lg">access now</a>

                <p>You will be charged a one time administrative fee of $19.95 to be able to view your personalized
                    astrology map report. No other charges will be made for this service and you will be able to use
                    view this report.</p>
            </div>
        </div>
    </div>
</div>

<!-- Romantic Modal -->
<div class="modal fade" id="romantic-map-modal-id" tabindex="-1" role="dialog"
     aria-labelledby="romantic-map-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content text-center">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Romantic Compatibility Report </h4>
            </div>
            <div class="modal-body">
                <img src="/images/romantic-map-modal.png" alt=""/>

                <div class="headline">Your best and most accurate resource for romantic comparison. Compare the cosmos
                    between you and your partner with the best chart report system.
                </div>
            </div>
            <div class="modal-footer">
                <a href="/dashboard/romantic-report" class="btn btn-success btn-green btn-lg">start now</a>

                <p>You will be charged a one time administrative fee of $19.95 to be able to view your Personalized
                    Romantic Compatibility Report. No other charges will be made for this service and you will be able
                    to use view this report. </p>
            </div>
        </div>
    </div>
</div>

<!-- Future Modal -->
<div class="modal fade" id="future-forecast-modal-id" tabindex="-1" role="dialog"
     aria-labelledby="future-forecast-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content text-center">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Future Forecast Map Report</h4>
            </div>
            <div class="modal-body">
                <img src="/images/future-forecast.png" alt=""/>

                <div class="headline">See whats in store for you in the next few months or year! Find out with this
                    report that describes your upcoming transits for a three month period!
                </div>
            </div>
            <div class="modal-footer">
                <a href="" id="buy_future_report" class="btn btn-success btn-green btn-lg">view now</a>

                <p>You will be charged a one time administrative fee of $19.95 to be able to view your Future Forecast
                    Map Report. No other charges will be made for this service and you will be able to use view this
                    report. </p>
            </div>
        </div>
    </div>
</div>

@include('layouts._footer')


</body>
</html>