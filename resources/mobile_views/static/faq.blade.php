@extends('layouts.static')

@section('content')

    <div class="top-container">
        <div class="footer-links-menu">
            <div class="container">
                <ul class="nav nav-pills nav-justified">
                    <li><a href="{{ url('about') }}">About</a></li>
                    <li><a href="{{ url('privacy') }}">Privacy</a></li>
                    <li><a href="{{ url('terms') }}">Terms</a></li>
                    <li class="active"><a href="{{ url('faq') }}">FAQ</a></li>
                    <li><a href="{{ url('contact') }}">Contact</a></li>
                    <li><a href="{{ url('join') }}">Join as Advisor</a></li>
                </ul>
            </div>
        </div>
        <h2 class="footer-page-headline">
            <div class="container">FAQ</div>
        </h2>
    </div>
    <div class="bottom-container">
        <div class="container">
            <div class="row">
                <div class="col col-sm-6">
                    <div class="faq-item">
                        <img src="../images/faq-item.png" alt=""/>
                        <p class="question">What is golookup.com?</p>
                        <p class="answer">GoLookUp is a public data aggregator. We gather data from a number of sources and allow you to easily search millions of records. You may search for a person’s background or find out information about a number that has been calling you.<br/>Our reports gives detailed data of public records such as court records, emails, social information, martial status, phone numbers, sex offenders, criminal records and much more.</p>
                    </div>
                    <div class="faq-item">
                        <img src="../images/faq-item.png" alt=""/>
                        <p class="question">What is golookup.com?</p>
                        <p class="answer">GoLookUp is a public data aggregator. We gather data from a number of sources and allow you to easily search millions of records. You may search for a person’s background or find out information about a number that has been calling you.<br/>Our reports gives detailed data of public records such as court records, emails, social information, martial status, phone numbers, sex offenders, criminal records and much more.</p>
                    </div>
                    <div class="faq-item">
                        <img src="../images/faq-item.png" alt=""/>
                        <p class="question">What is golookup.com?</p>
                        <p class="answer">GoLookUp is a public data aggregator. We gather data from a number of sources and allow you to easily search millions of records. You may search for a person’s background or find out information about a number that has been calling you.<br/>Our reports gives detailed data of public records such as court records, emails, social information, martial status, phone numbers, sex offenders, criminal records and much more.</p>
                    </div>
                </div>
                <div class="col col-sm-6">
                    <div class="faq-item">
                        <img src="../images/faq-item.png" alt=""/>
                        <p class="question">What is golookup.com?</p>
                        <p class="answer">GoLookUp is a public data aggregator. We gather data from a number of sources and allow you to easily search millions of records. You may search for a person’s background or find out information about a number that has been calling you.<br/>Our reports gives detailed data of public records such as court records, emails, social information, martial status, phone numbers, sex offenders, criminal records and much more.</p>
                    </div>
                    <div class="faq-item">
                        <img src="../images/faq-item.png" alt=""/>
                        <p class="question">What is golookup.com?</p>
                        <p class="answer">GoLookUp is a public data aggregator. We gather data from a number of sources and allow you to easily search millions of records. You may search for a person’s background or find out information about a number that has been calling you.<br/>Our reports gives detailed data of public records such as court records, emails, social information, martial status, phone numbers, sex offenders, criminal records and much more.</p>
                    </div>
                    <div class="faq-item">
                        <img src="../images/faq-item.png" alt=""/>
                        <p class="question">What is golookup.com?</p>
                        <p class="answer">GoLookUp is a public data aggregator. We gather data from a number of sources and allow you to easily search millions of records. You may search for a person’s background or find out information about a number that has been calling you.<br/>Our reports gives detailed data of public records such as court records, emails, social information, martial status, phone numbers, sex offenders, criminal records and much more.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection