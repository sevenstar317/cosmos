<!DOCTYPE html>
<html lang="en">
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
    <script  src="{{ elixir('js/all.js') }}"></script>
    <script async src="{{ elixir('js/custom.min.js') }}"></script>


    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 10]>
    <script src="./js/html5shiv.js"></script>
    <script src="./js/respond.min.js"></script>
    <![endif]-->
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-84489439-1', 'auto');
        ga('send', 'pageview');

    </script>
</head>
<body @if(!Request::is('/') && Request::is('/horoscope')) class="flow-page"@endif>

<div class="container-fluid main-wrapper">
    <header>
        <div class="container">
            <nav class="navbar" role="navigation">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu-id">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="logo-link" href="/"><img class="img-responsive" src="/images/logo.png" alt=""/></a>
                    </div>
                    <div class="collapse navbar-collapse" id="menu-id">
                        <ul class="nav navbar-nav navbar-right main-menu">
                            <?php  if(Auth::guest()): ?>
                                <li><a class="btn btn-sm btn-primary sign-in" href="{{ url('/login') }}">Sign in</a></li>
                                <?php if ($_SERVER['HTTP_HOST'] !== 'trackingcsm.livecosmos.com' && $_SERVER['HTTP_HOST'] !== 'm.livecosmos.com') { ?>
                                    <li><a class="btn btn-sm btn-info sign-up" href="{{ url('/register2') }}">Register</a></li>
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
    <div class="">
       @yield('content')
    </div>
</div>

@include('layouts._footer')

<script type="text/javascript">

</script>

</body>
</html>