@extends('layouts.static')

@section('content')

    <div class="top-container">
        <div class="footer-links-menu">
            <div class="container">
                <ul class="nav nav-pills nav-justified">
                    <li class="active"><a href="{{ url('about') }}">About</a></li>
                    <li><a href="{{ url('privacy') }}">Privacy</a></li>
                    <li><a href="{{ url('terms') }}">Terms</a></li>
                    <li><a href="{{ url('faq') }}">FAQ</a></li>
                    <li><a href="{{ url('contact') }}">Contact</a></li>
                    <li><a href="{{ url('join') }}">Join as Advisor</a></li>
                </ul>
            </div>
        </div>
        <h2 class="footer-page-headline">
            <div class="container">What we do</div>
        </h2>
    </div>
    <div class="bottom-container">
        <div class="container">
            <p>We spend much of our life trying to "find our way" - find our way to true love, to our dreams, to a happy and fulfilling life. With Kasamba, you can always count on the caring wisdom and guidance of top-rated psychics to help you on your journey.<br/>Since 1999, more than 2 million users have made Kasamba their choice for psychic readings, tarot readings, astrology, and more. The psychics on Kasamba have been given 5-star ratings by their customers on more than 3 million readings, so enjoy yours knowing that your psychic has earned a reputation for being the best. Using our website, mobile site, or calling toll-free, our customers have 24/7 access to thousands of online psychics for readings via text chat, phone, and email.</p>
            <div class="about-items text-center">
                <div class="row">
                    <div class="col col-sm-6">
                        <div class="about-item">
                            <img src="../images/about-item-1.png" alt=""/>
                            <p>innovative on point & personalized system that reveals your life problems</p>
                        </div>
                        <div class="about-item">
                            <img src="../images/about-item-2.png" alt=""/>
                            <p>support and answers</p>
                        </div>
                    </div>
                    <div class="col col-sm-6">
                        <div class="about-item">
                            <img src="../images/about-item-3.png" alt=""/>
                            <p>readings with your<br/> horoscope sign experts</p>
                        </div>
                        <div class="about-item">
                            <img src="../images/about-item-4.png" alt=""/>
                            <p>secured & 100% confidential</p>
                        </div>
                    </div>
                </div>
            </div>
            <p>Here are some of the features and benefits you'll enjoy with Kasamba:</p>
            <ul>
                <li> New customers always start with a free psychic reading</li>
                <li>Your first reading with any new psychic advisor always starts free</li>
                <li>Get discounts and special offers through email, Facebook, Twitter, and more</li>
                <li>Satisfaction guarantee</li>
                <li>"Presto chat" - innovative online chat interface means no waiting - text displays as it’s entered</li>
                <li>No prepayment - pay safely and securely via credit/debit card or PayPal when you're ready</li>
                <li>Get psychic readings via online chat, phone, email, and online Q&A</li>
                <li>Choose from thousands of psychics available 24/7 via web, mobile, and toll-free</li>
            </ul>
        </div>
    </div>

@endsection