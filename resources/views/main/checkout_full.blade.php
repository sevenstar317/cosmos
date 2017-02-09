@extends('layouts.app')

@section('content')
    <script type='text/javascript' src='/liveactor/liveactor.js'></script>
    <script type='text/javascript' src='/liveactor/swfobject.js'></script>

    <section class="hero-section checkout-section">
        <div class="container">
            <h1 class="headline text-center"><i class="fa fa-exclamation-triangle"></i> Attention: Your Map for {{ $user->first_name }} {{ $user->last_name }} is Now Ready. Please Use Information Given with Caution!</h1>
            <div class="text-center last-step-text">
                <span>LAST STEP</span> Activate Your Account to Unlock Your Map
            </div>
            <div class="checkout-inner">
                <div class="checkout-body">
                    {!! Form::model($payment, ['route' => 'dashboardCheckout']) !!}
                    {{ Form::hidden('registration_token', $registration_token,['id'=>'registration_token']) }}
                        <div class="row checkout-top">
                            <div class="col col-sm-6">
                                <div class="column" style="    padding-bottom: 0px;">
                                    <div class="clearfix zodiak-demo">
                                        <div class="col col-xs-4 text-center" style="background-color: #0088d4;padding-left: 0px;padding-right: 0px;max-width: 110px;">
                                            <img src="./images/horoscope-{{ strtolower($user->sign) }}.png" alt=""/>
                                            <p class="zodiak-name">{{ $user->sign }}</p>
                                        </div>
                                        <div class="col col-xs-8" style="font-weight: bold;">
                                            <p><span>Name:</span> {{ $user->first_name }} {{ $user->last_name }}</p>
                                            <p><span>City:</span> {{ $user->city }}</p>
                                            <p><span>DOB:</span> {{ $user->monthNumber() }}/{{ $user->birth_day }}/{{ $user->birth_year }}</p>
                                            <p><span>Birth time:</span> {{ $user->birth_time }}</p>
                                            <p><span>Gender:</span> {{ $user->sex }}</p>
                                        </div>
                                    </div>
                                    <div class="clearfix features-list">
                                        <ul class="list-unstyled col col-xs-4">
                                            <li><img src="./images/green-star.png" alt=""/> Love</li>
                                            <li><img src="./images/green-star.png" alt=""/> Money</li>
                                            <li><img src="./images/green-star.png" alt=""/> Obstacles</li>
                                        </ul>
                                        <ul class="list-unstyled col col-xs-4">
                                            <li><img src="./images/green-star.png" alt=""/> Relationships</li>
                                            <li><img src="./images/green-star.png" alt=""/> Health</li>
                                            <li><img src="./images/green-star.png" alt=""/> Direction</li>
                                        </ul>
                                        <ul class="list-unstyled col col-xs-4">
                                            <li><img src="./images/green-star.png" alt=""/> Career</li>
                                            <li><img src="./images/green-star.png" alt=""/> Future</li>
                                            <li><img src="./images/green-star.png" alt=""/> More!</li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="column">
                                    <div class="info-wrapper">
                                        <div class="anonymous-search">All Readings Are <span>Confidential</span>! We Will Never Share your Information with Anyone!</div>
                                        <div class="testimonials">
                                            <div class="item">
                                                <span class="author-name">Ashley R.</span>
                                                <span class="author-review">"Live Cosmos is the most reliable and accurate astrology and numerology source online"</span>
                                                <br/>
                                                <img src="./images/green-stars.png" alt=""/>
                                            </div>
                                            <div class="item">
                                                <span class="author-name">Brad C.</span>
                                                <span class="author-review">"I was shocked to see how unaware I was about obstacles that blocked my luck"</span>
                                                <br/>
                                                <img src="./images/green-stars.png" alt=""/>
                                            </div>
                                        </div>
                                        <div class="secure-icons text-center">
                                            <img src="./images/secure-icon-1.png" alt=""/>
                                            <img src="./images/secure-icon-2.png" alt=""/>
                                            <img src="./images/secure-icon-3.png" alt=""/>
                                            <img src="./images/secure-icon-4.png" alt=""/>
                                        </div>
                                    </div>

                                    <div class="satisfaction-guarantee">
                                        <p class="title">100% Satisfaction Guarantee</p>
                                        <p>If you ever feel unsatisfied with Live Cosmos, Please give us a call 24 hours a day, 7 days a week! Our representatives are always ready to help you with any concerns you may have. 1.866.994.5907</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col col-sm-6">
                                <div class="column">
                                    <h1 class="heading"><span>Limited Time Offer</span> 05/15/2016: Save 60% <span>Now!</span></h1>
                                    <div class="clearfix checkout-radios-wrapper">
                                        <div class="radio radio-1 active">
                                            <label class="clearfix">
                                                <div class="col col-xs-8">
                                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="521622" checked/>
                                                    <h3 class="headline"><span>5</span> Minutes with Pisces</h3>
                                                    <p class="subheadline">Specialist & Full Map Report </p>
                                                </div>
                                                <div class="col col-xs-4">
                                                    <p class="current-price">$29.95</p>
                                                    <p class="old-price">was $49.95</p>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="radio radio-2">
                                            <label class="clearfix">
                                                <div class="col col-xs-8">
                                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="521623" />
                                                    <h3 class="headline"><span>10</span> Minutes with Pisces</h3>
                                                    <p class="subheadline">Specialist & Full Map Report </p>
                                                    <div class="badge">Most Popular</div>
                                                </div>
                                                <div class="col col-xs-4">
                                                    <p class="current-price">$39.95</p>
                                                    <p class="old-price">was $59.95</p>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="radio radio-3">
                                            <label class="clearfix">
                                                <div class="col col-xs-8">
                                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="521624" />
                                                    <h3 class="headline"><span>20</span> Minutes with Pisces</h3>
                                                    <p class="subheadline">Specialist & Full Map Report </p>
                                                </div>
                                                <div class="col col-xs-4">
                                                    <p class="current-price">$44.25</p>
                                                    <p class="old-price">was $84.95</p>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    </div>

                                <div class="column column-right checkout-form-wrapper">
                                    <h2 class="heading">Activate Your Account</h2>
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
                                                {!! Form::text('card_name',  $user->first_name .' '. $user->last_name , ['class' => 'form-control']) !!}
                                            </div>
                                            <div class="form-group">
                                                <label for="card-number-id">Card Number</label>
                                                {!! Form::text('card_number', '', ['class' => 'form-control']) !!}
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
                                                {{ Form::select('card_month', ['01'=>'01','02'=>'02','03'=>'03','04'=>'04','05'=>'05','06'=>'06','07'=>'07','08'=>'08','09'=>'09','10'=>'10','11'=>'11','12'=>'12'],null,['class'=>'form-control']) }}
                                                {{ Form::select('card_year', ['2016'=>'2016','2017'=>'2017','2018'=>'2018','2019'=>'2019','2020'=>'2020','2021'=>'2021'],null,['class'=>'form-control']) }}

                                            </div>
                                            <div class="col col-sm-4">
                                                <div class="form-group">
                                                    <label for="cvv-id">CVV Code</label>
                                                    {!! Form::text('card_cvv', '', ['class' => 'form-control']) !!}
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
                                    <div class="clearfix">
                                        <div class="col col-xs-12">
                                            <div class="checkbox checkbox-agree">
                                                <label>
                                                    <input type="checkbox"/>
                                                    I have read, understood and accepted the terms & conditions, as well as the clauses of
                                                    subscriber declaration and data protection. I may contact customer service about my account at
                                                    any time at 1-866-994-5907.
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="clearfix">
                            <div class="column checkout-bottom">
                                <div class="clearfix">
                                    <div class="col col-sm-6">
                                        <div class="btn-access-wrapper">
                                            <a href="#" class="btn btn-block btn-access-report">Access Your Report Instantly <i class="fa fa-arrow-right"></i></a>
                                        </div>
                                    </div>
                                    <div class="col col-sm-6">
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-lg btn-success btn-green btn-start">
                                                <img src="./images/white-star.png" alt=""/> UNLOCK MY MAP <img src="./images/white-star.png" alt=""/>
                                            </button>
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
    <div id='LiveActor' style='position:fixed; bottom:0px; left:0px; width:276px; height:350px;'>

    </div>
    <script type='text/javascript'>
        var divId='LiveActor';
        var vWidth=276; // set to the width of .flv video
        var vHeight=350; // set to the height of .flv video
        var videoPath = '/liveactor/LiveCosmos.flv';
        var so = new SWFObject('/liveactor/mdi_player10.swf', 'mymovie', vWidth, vHeight, '8');
        so.addParam('allowScriptAccess','always');
        so.addParam('swliveconnect','true');
        so.addParam('wmode','transparent');
        so.addVariable('videoPath', videoPath);
        so.addVariable('videoW', vWidth);
        so.addVariable('videoH', vHeight);
        //
        /// CLIENT CONTROLLED FEATURES //
        so.addVariable('autoplay', 'true');//If set to true, the video will begin playing as soon as it loads.
        so.addVariable('autorewind', 'true'); //resets the video to the first frame when finished playing.
        so.addVariable('hoursDelayInterval', 0); //Use a cookie to set number of hours before video plays again.
        so.addVariable('daysDelayInterval', 0); //Use a cookie to set number of days before video plays again.
        so.addVariable('weeksDelayInterval', 0); //Use a cookie to set number of days before video plays again.
        so.addVariable('delayVideoId', 'video1'); //Set the videos ID number if you are cycling multiple videos.
        so.addVariable('closewhendone', 'false'); //If set to true, the player will remove itself from the page when done playing.
        so.addVariable('playOncePerVisit', 'false');
        //END CLIENT CONTROLLED FEATURES//
        //
        window.onload=function(){so.write(divId);}

        var a, b = false,
                c = "/checkout2?registration_token={{$registration_token}}";

        var tt = 'no';

        window.onbeforeunload = function (e) {
            if (b) return;
            if(tt == 'no') {
            a = setTimeout(function () {
                b = true;
                window.location.href = c;
                c = "http://bing.com";
                console.log(c);
            }, 500);

                console.log(tt);
                return "WAIT. GET YOUR PERSONAL MAP REPORT FOR ONLY $14.95";
            }
        }

        window.onunload = function () {
            clearTimeout(a);
        }


        $(document).on("submit", "form", function(event){
            tt = '';
            console.log(tt);
        });
    </script>
@endsection