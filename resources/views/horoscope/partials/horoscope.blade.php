@extends('layouts.app')

@section('content')

<div class="website-content">
    <section class="hero-sections hero-horoscope hero-{{ $sign_title }}">
        <div class="container">
            <h2 class="text-center title">Personalized {{ $sign_title }} Horoscope Report</h2>
            <h3 class="text-center subtitle">Reports are Based on Name, Date, Time of Birth, Location and More!</h3>
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
    <section class="horoscope-description">
        <div class="container">
            <p>{{ $sign['description'] }}</p>
        </div>
    </section>
</div>

@endsection