@extends('layouts.app')

@section('content')

<div class="website-content">
    <section class="hero-sections hero-homes">
        <div class="container">
            <form action="/register2" method="GET"  role="form" class="form form-inline">
                <div class="row">
                    <div class="col col-sm-5 form-group">
                        <input type="text" class="form-control input-lg" name="first_name" placeholder="First name"/>
                    </div>
                    <div class="col col-sm-5 form-group">
                        <input type="text" class="form-control input-lg" name="last_name" placeholder="Last name"/>
                    </div>
                    <div class="col col-sm-2 form-group">
                        <button type="submit" class="btn btn-success btn-lg btn-block btn-start">Start</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <section class="horoscope-directory">
        <div class="container">
            <h2 class="title">Horoscope Directory - Popular Terms and Dates</h2>
            <p>How accurate are the horoscopes you read? How do you know if what you are reading is the exact description of what is going on in your life. The cosmos have tremendous affect on our lives. If only we were able to interpret them and gain a deeper understanding on how we can change our lives now and in the future. Live Cosmos offers gives you the tools to unlock your life.</p>
            <p>Click on your horoscope sign below to begin your personal cosmos journey.</p>
        </div>
    </section>
    <section class="horoscopes-list text-center">
        <div class="container">
            <div class="clearfix">
                <ul class="list-unstyled list-inline">
                    <li>
                        <a href="/horoscope/aries">
                            <img src="./images/horoscope_images/aries-sm.png" alt=""/>
                            <span>aries</span>
                        </a>
                    </li>
                    <li>
                        <a href="/horoscope/taurus">
                            <img src="./images/horoscope_images/taurus-sm.png" alt=""/>
                            <span>taurus</span>
                        </a>
                    </li>
                    <li>
                        <a href="/horoscope/gemini">
                            <img src="./images/horoscope_images/gemini-sm.png" alt=""/>
                            <span>gemini</span>
                        </a>
                    </li>
                    <li>
                        <a href="/horoscope/cancer">
                            <img src="./images/horoscope_images/cancer-sm.png" alt=""/>
                            <span>cancer</span>
                        </a>
                    </li>
                    <li>
                        <a href="/horoscope/leo">
                            <img src="./images/horoscope_images/leo-sm.png" alt=""/>
                            <span>leo</span>
                        </a>
                    </li>
                    <li>
                        <a href="/horoscope/virgo">
                            <img src="./images/horoscope_images/virgo-sm.png" alt=""/>
                            <span>virgo</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="clearfix">
                <ul class="list-unstyled list-inline">
                    <li>
                        <a href="/horoscope/libra">
                            <img src="./images/horoscope_images/libra-sm.png" alt=""/>
                            <span>libra</span>
                        </a>
                    </li>
                    <li>
                        <a href="/horoscope/scorpius">
                            <img src="./images/horoscope_images/scorpius-sm.png" alt=""/>
                            <span>scorpius</span>
                        </a>
                    </li>
                    <li>
                        <a href="/horoscope/sagittarius">
                            <img src="./images/horoscope_images/sagittarius-sm.png" alt=""/>
                            <span>sagittarius</span>
                        </a>
                    </li>
                    <li>
                        <a href="/horoscope/capricorn">
                            <img src="./images/horoscope_images/capricornus-sm.png" alt=""/>
                            <span>capricornus</span>
                        </a>
                    </li>
                    <li>
                        <a href="/horoscope/aquarius">
                            <img src="./images/horoscope_images/aquarius-sm.png" alt=""/>
                            <span>aquarius</span>
                        </a>
                    </li>
                    <li>
                        <a href="/horoscope/pisces">
                            <img src="./images/horoscope_images/pisces-sm.png" alt=""/>
                            <span>pisces</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </section>
</div>

@endsection