<!DOCTYPE html>
<html lang="en" ng-app="app">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Live Cosmos provides personalized astrology readings based on your specific name, date of birth, time of birth, location and more! ">
    <meta name="keywords" content="Astrology readings, Personalized Astrology Readings, Astrology, Cosmos, Live Cosmos, Tarot Readings, Psychic Readings, Psychic, Tarot, Horoscope readings, horoscope, astrology reading, personal astrology, astrology charts, astrology online, astrology chat, chat astrology, psychic online, tarot online, horoscope online, personal astrology online, astrologist online, psychic medium, check my astrology, check astrology, check horoscope">

    <title>Live Cosmos - Personalized Astrology Readings, Reports & more!</title>


    <link href="{{ elixir('css/style.css') }}" rel="stylesheet">
    <link href="{{ elixir('css/app.css') }}" rel="stylesheet">
    <link href="{{ elixir('css/all.css') }}" rel="stylesheet">

    <script src="{{ elixir('js/all.js') }}"></script>
    <script src="{{ elixir('js/bundle.min.js') }}"></script>
    <script src="{{elixir('js/custom.min.js') }}"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 10]>
    <script src="./js/html5shiv.js"></script>
    <script src="./js/respond.min.js"></script>
    <![endif]-->

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBWn7IAyvJ-B3vsIqVgRFVO2oj0UwFgiJI&"
    ></script>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-84489439-1', 'auto');
        ga('send', 'pageview');

    </script>
</head>
<body class="chat-page">

<div class="main-wrapper">
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
                            <?php  if(Auth::guest() && Auth::guard('agent')->guest()): ?>
                                <li><a class="btn btn-sm btn-primary sign-in" href="{{ url('/chat-advisor/login') }}">Sign in</a></li>
                                <li><a class="btn btn-sm btn-info sign-up" href="{{ url('/chat-advisor/register') }}">Register</a></li>
                            <?php else: ?>
                                <li><button class="btn btn-sm btn-primary sign-in" style="    font-size: 15px;" id="logout_button" >Sign out</button></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <div class="website-content clearfix">
        @yield('content')
    </div>

</div>

@include('layouts._footer')

</body>
</html>