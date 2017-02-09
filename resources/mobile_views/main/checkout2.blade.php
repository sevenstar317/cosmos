@extends('layouts.app')

@section('content')

    <section class="hero-section checkout2-section">
        <div class="container">
            <h1 class="headline text-center">Get your personal map report</h1>
            <div class="text-center last-step-text">Limited time offer only $19.95</div>
            <div class="checkout2-inner">
                <div class="checkout2-body">
                    {!! Form::model($payment, ['route' => 'checkout2']) !!}
                    {{ Form::hidden('registration_token', $registration_token,['id'=>'registration_token']) }}
                        <div class="row checkout2-top">
                            <div class="col col-sm-6">
                                <div class="column personal-map">
                                    <h1 class="heading">Personal astrology cosmos map</h1>
                                    <div class="clearfix checkout2-radios-wrapper">
                                        <div class="radio radio-1 radio-single active">
                                            <label class="clearfix">
                                                <div class="headline-wrapper">
                                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="521630" checked/>
                                                    <h3 class="headline">Personal<br/>astrology report</h3>
                                                    <div class="current-price">$19.95</div>
                                                </div>
                                            </label>
                                        </div>

                                    </div>
                                </div>

                                <div class="column  checkout2-form-wrapper">
                                    <h2 class="heading"> Validate Your Account. You Will Not Be Charged.</h2>
                                    @if($errors->any())
                                        <div class="alert alert-danger">
                                            @foreach ($errors->all() as $error)
                                                {{ $error }}<br>
                                            @endforeach
                                        </div>
                                    @endif
                                    <div class="clearfix">
                                        <div class="col col-xs-12">
                                            <div class="form-group">
                                                <label for="name-id">Name on Card</label>
                                                {!! Form::text('card_name',  $user->first_name .' '. $user->last_name , ['class' => 'form-control','required'=>'required']) !!}
                                            </div>
                                            <div class="form-group">
                                                <label for="name-id">Email</label>
                                                {!! Form::text('email',  '' , ['class' => 'form-control','required'=>'required']) !!}
                                            </div>
                                            <div class="form-group">
                                                <label for="card-number-id">Card Number</label>
                                                {!! Form::text('card_number', '', ['class' => 'form-control','required'=>'required']) !!}
                                            </div>
                                            <div class="form-group">
                                                <img src="./images/visa.png" alt=""/>
                                                <img src="./images/mastercard.png" alt=""/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix">
                                        <div class="form-group">
                                            <div class="col col-sm-8 expiration-age">
                                                <label>Expiration Date</label>
                                                {{ Form::select('card_month', ['01'=>'01','02'=>'02','03'=>'03','04'=>'04','05'=>'05','06'=>'06','07'=>'07','08'=>'08','09'=>'09','10'=>'10','11'=>'11','12'=>'12'],null,['class'=>'form-control','required'=>'required']) }}
                                                {{ Form::select('card_year', ['2016'=>'2016','2017'=>'2017','2018'=>'2018','2019'=>'2019','2020'=>'2020','2021'=>'2021'],null,['class'=>'form-control','required'=>'required']) }}

                                            </div>
                                            <div class="col col-sm-4">
                                                <div class="form-group">
                                                    <label for="cvv-id">CVV Code</label>
                                                    {!! Form::text('card_cvv', '', ['class' => 'form-control','required'=>'required']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix">
                                        <div class="col col-xs-6">
                                            <div class="form-group">
                                                <label for="zip-id">Zip/Postal Code</label>
                                                {!! Form::text('zip', '', ['class' => 'form-control']) !!}
                                            </div>
                                        </div>
                                    </div>


                                    <div class="clearfix text-center">
                                        <div class="col col-xs-12">
                                            <button type="submit" class="btn btn-success btn-green btn-lg">Unlock my report</button>
                                            <p class="agree-terms">By clicking on the "unlock my report" button you are agreeing to our terms and conditions.</p>
                                                    </div>
                                                </div>


                            <div class="spaceholder"></div>
                                    </div>
                                </div>

                            <div class="col col-sm-6">
                                <div class="column">
                                    <h1 class="heading">Report includes</h1>
                                    <div class="clearfix report-includes">
                                        <div class="col col-xs-6 col-sm-12 col-md-6">
                                            <ul class="list-unstyled">
                                                <li><i class="fa fa-chevron-circle-right"></i> Personality Analysis</li>
                                                <li><i class="fa fa-chevron-circle-right"></i> Affecting Stars & Moons</li>
                                                <li><i class="fa fa-chevron-circle-right"></i> Obstacles</li>
                                                <li><i class="fa fa-chevron-circle-right"></i> Energies & Focus Details</li>
                                                <li><i class="fa fa-chevron-circle-right"></i> Challenges</li>
                                            </ul>
                                        </div>
                                        <div class="col col-xs-6 col-sm-12 col-md-6">
                                            <ul class="list-unstyled">
                                                <li><i class="fa fa-chevron-circle-right"></i> Weaknesses</li>
                                                <li><i class="fa fa-chevron-circle-right"></i> Strengths</li>
                                                <li><i class="fa fa-chevron-circle-right"></i> Astrology Houses</li>
                                                <li><i class="fa fa-chevron-circle-right"></i> Astrology Charts</li>
                                                <li><i class="fa fa-chevron-circle-right"></i> Your Purpose</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="column">
                                    <h1 class="heading">Map report sample preview</h1>
                                    <div class="clearfix map-report-sample">
                                        <div class="text-center">
                                            <img class="img-responsive" src="./images/astrology-map.png" alt=""/>
                                        </div>
                                        <p><strong>Introduction</strong><br/>Your natal horoscope, or birth chart, is a snapshot of the heavens at the moment you were born. It shows what the sky actually looked like at the time and place of your birth.</p>
                                        <p><strong>Funnel, Focal Planet Uranus:</strong> Uranus in the Third House (or sign) gives an individual who is restless and mentally acute, with an ability to grasp new concepts quickly.</p>
                                        <p><strong>Neptune in Taurus, in the Eleventh House:</strong><br/> The ruler of your Sun sign is characteristic of your personality - Neptune in the Eleventh House (or sign) gives a visionary personality with altruistic principles. You are popular, and may have a wide circle of friends. On the other hand, you may have problems to be worked through with deception in friendships, or confusion regarding a friend's true motives, or issues of using social interaction to escape your responsibilities.</p>
                                        <p>
                                            <img src="./images/text-blured.png" class="img-responsive" alt=""/>
                                        </p>
                                        <div class="security-icons text-center">
                                            <img src="./images/security-icon-1.png" alt=""/>
                                            <img src="./images/security-icon-2.png" alt=""/>
                                            <img src="./images/security-icon-3.png" alt=""/>
                                            <img src="./images/security-icon-4.png" alt=""/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>


                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </section>

@endsection