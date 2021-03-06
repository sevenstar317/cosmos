@extends('layouts.app')

@section('content')
    <section class="hero-section flow-section select-sign">
        <div class="container">
            <div class="flow-inner text-center">
                <ul class="steps-list list-inline list-unstyled">
                    <li>{{ $user->sign }}</li>
                    <li>{{ $user->sex }}</li>
                </ul>
                <p class="flow-title">Enter Your Birth Date</p>
                <form class="form" action="{{ action('MainController@step4') }}">
                    {{ Form::hidden('registration_token', $registration_token) }}
                    <div class="form-group buttons-list {{ $errors->has('birth_day') ? ' has-error' : '' }}" >
                        <div class="btn-group">
                            <button type="button" class="btn btn-lg btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Month <img src="../images/arrow-up-down.png" alt=""/>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="#">January</a></li>
                                <li><a href="#">February</a></li>
                                <li><a href="#">March</a></li>
                                <li><a href="#">April</a></li>
                                <li><a href="#">May</a></li>
                                <li><a href="#">June</a></li>
                                <li><a href="#">July</a></li>
                                <li><a href="#">August</a></li>
                                <li><a href="#">September</a></li>
                                <li><a href="#">October</a></li>
                                <li><a href="#">November</a></li>
                                <li><a href="#">December</a></li>
                            </ul>
                            <input type="text" class="pseoudo-hidden-input" name="birth_month" required value=""/>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-lg btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Day <img src="../images/arrow-up-down.png" alt=""/>
                            </button>
                            <ul class="dropdown-menu">
                                @for($i = 1; $i < 32; $i++)
                                    <li><a href="#">{{$i}}</a></li>
                                @endfor
                            </ul>
                            <input type="text" class="pseoudo-hidden-input" name="birth_day" required value=""/>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-lg btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Year <img src="../images/arrow-up-down.png" alt=""/>
                            </button>
                            <ul class="dropdown-menu">
                                @for($i = 1998; $i >= 1930; $i--)
                                    <li><a href="#">{{$i}}</a></li>
                                @endfor
                            </ul>
                            <input type="text" name="birth_year" class="pseoudo-hidden-input" required value=""/>
                        </div>
                    </div>
                    @if ($errors->has('birth_day'))
                        <span class="help-block" style="color:red;">
                                        <strong>{{ $errors->first('birth_day') }}</strong>
                                    </span>
                    @endif
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-lg btn-green btn-flow">next</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <section class="special-advisors-section"  style="background-color: white;">
        <h1 class="title text-center"><span>Sign Based Chat Advisors </span> to Match Your Horoscope Sign & Birth Date!</h1>
        <div class="container">
            <div class="row">
                <div class="col col-sm-4">
                    <div class="advisor-container text-center">
                        <img src="./images/logo.png" alt="" class="img-responsive"/>
                        <div class="advisor-image">
                            <img src="/images/goni.jpg" style="height:255px;" alt="" class="img-responsive"/>
                        </div>
                        <div class="advisor-name">Chat with Gonen</div>
                        <div class="row controls">
                            <div class="col col-xs-6">
                                <a href="">
                                    <img src="./images/add-funds.png" alt="" class="img-responsive"/>
                                    <span>Add Minutes</span>
                                </a>
                            </div>
                            <div class="col col-xs-6">
                                <a href="">
                                    <img src="./images/end-chat.png" alt="" class="img-responsive"/>
                                    <span>End Chat</span>
                                </a>
                            </div>
                        </div>
                        <div class="time">00:02:45</div>
                        <div class="package-type-wrapper">
                            <div class="clearfix">
                                <div class="col col-xs-6">Package Type</div>
                                <div class="col col-xs-6 package-type">5 Minutes</div>
                            </div>
                        </div>
                        <div class="row controls">
                            <div class="col col-xs-6">
                                <a href="">
                                    <img src="./images/email-chat.png" alt="" class="img-responsive"/>
                                    <span>Email Chat</span>
                                </a>
                            </div>
                            <div class="col col-xs-6">
                                <a href="">
                                    <img src="./images/download-chat.png" alt="" class="img-responsive"/>
                                    <span>Download Chat</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col col-sm-4">
                    <div class="advisor-container text-center">
                        <img src="./images/logo.png" alt="" class="img-responsive"/>
                        <div class="advisor-image">
                            <img src="./images/iris.jpg" style="height:255px;" alt="" class="img-responsive"/>
                        </div>
                        <div class="advisor-name">Chat with Iris</div>
                        <div class="row controls">
                            <div class="col col-xs-6">
                                <a href="">
                                    <img src="./images/add-funds.png" alt="" class="img-responsive"/>
                                    <span>Add Minutes</span>
                                </a>
                            </div>
                            <div class="col col-xs-6">
                                <a href="">
                                    <img src="./images/end-chat.png" alt="" class="img-responsive"/>
                                    <span>End Chat</span>
                                </a>
                            </div>
                        </div>
                        <div class="time">00:02:45</div>
                        <div class="package-type-wrapper">
                            <div class="clearfix">
                                <div class="col col-xs-6">Package Type</div>
                                <div class="col col-xs-6 package-type">5 Minutes</div>
                            </div>
                        </div>
                        <div class="row controls">
                            <div class="col col-xs-6">
                                <a href="">
                                    <img src="./images/email-chat.png" alt="" class="img-responsive"/>
                                    <span>Email Chat</span>
                                </a>
                            </div>
                            <div class="col col-xs-6">
                                <a href="">
                                    <img src="./images/download-chat.png" alt="" class="img-responsive"/>
                                    <span>Download Chat</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col col-sm-4">
                    <div class="advisor-container text-center">
                        <img src="./images/logo.png" alt="" class="img-responsive"/>
                        <div class="advisor-image">
                            <img src="./images/anna.jpg" style="height:255px;" alt="" class="img-responsive"/>
                        </div>
                        <div class="advisor-name">Chat with Anna</div>
                        <div class="row controls">
                            <div class="col col-xs-6">
                                <a href="">
                                    <img src="./images/add-funds.png" alt="" class="img-responsive"/>
                                    <span>Add Minutes</span>
                                </a>
                            </div>
                            <div class="col col-xs-6">
                                <a href="">
                                    <img src="./images/end-chat.png" alt="" class="img-responsive"/>
                                    <span>End Chat</span>
                                </a>
                            </div>
                        </div>
                        <div class="time">00:02:45</div>
                        <div class="package-type-wrapper">
                            <div class="clearfix">
                                <div class="col col-xs-6">Package Type</div>
                                <div class="col col-xs-6 package-type">5 Minutes</div>
                            </div>
                        </div>
                        <div class="row controls">
                            <div class="col col-xs-6">
                                <a href="">
                                    <img src="./images/email-chat.png" alt="" class="img-responsive"/>
                                    <span>Email Chat</span>
                                </a>
                            </div>
                            <div class="col col-xs-6">
                                <a href="">
                                    <img src="./images/download-chat.png" alt="" class="img-responsive"/>
                                    <span>Download Chat</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="questions-section" style="background-color: white;">
        <div class="container">
            <div class="row text-center">
                <div class="questions-inner text-left clearfix">
                    <ul class="list-unstyled col col-sm-6">
                        <li><i class="fa fa-circle"></i> Is he right for me?</li>
                        <li><i class="fa fa-circle"></i> Is my career right?</li>
                        <li><i class="fa fa-circle"></i> Can they commit?</li>
                        <li><i class="fa fa-circle"></i> How can I succeed?</li>
                    </ul>
                    <ul class="list-unstyled col col-sm-6">
                        <li><i class="fa fa-circle"></i> Are they the one?</li>
                        <li><i class="fa fa-circle"></i> Why am I not happy?</li>
                        <li><i class="fa fa-circle"></i> Am I over sensitive?</li>
                        <li><i class="fa fa-circle"></i> What do I need to change?</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <section class="performed-section text-center">
        <span>We Have Performed</span>
        <div class="counter-outer">
            <?php
            $now = time();
            $your_date = strtotime("2016-07-04"); //Starting date
            $datediff = floor(($now - $your_date)/(60*60*24)) * 500;
            $total = 257084 + $datediff;
            ?>
            <div class="counter-inner">
                <span>
                <?= number_format($total) ?>
                </span>
            </div>
        </div>
        <span>Live Readings and Counting...</span>
    </section>

    <section class="testimonials-section" style="background-color: white;">
        <div class="container">
            <h1 class="title text-center">See How the Cosmos Can <span>Change Your Life!</span></h1>
            <ul class="list-unstyled">
                <li class="clearfix">
                    <div class="col col-sm-2 hidden-xs">
                        <img class="img-responsive" src="./images/avatar.png" alt=""/>
                    </div>
                    <div class="col col-sm-10 review-details">
                        <span class="review-text">"I could not believe my eyes when I read what my advisor wrote! Thank You for giving me the points to turn my life around."</span>
                        <span class="review-author">Nichole S.</span>
                    </div>
                </li>
                <li class="clearfix">
                    <div class="col col-sm-2 hidden-xs">
                        <img class="img-responsive" src="./images/avatar.png" alt=""/>
                    </div>
                    <div class="col col-sm-10 review-details">
                        <span class="review-text">"We are all affected by energy. Live Cosmos reveals everything that blocks you in life by analyzing your DOB and Name."</span>
                        <span class="review-author">Mary V.</span>
                    </div>
                </li>
            </ul>
        </div>
    </section>
    <section class="why-livecosmos-section" style="background-color: white;">
        <div class="container">
            <div class="text-center">
                <img src="./images/why-livecosmos-icon.png" alt=""/>
            </div>
            <h1 class="title text-center">Why Live Cosmos</h1>
            <div class="row">
                <div class="col col-sm-6">
                    <ul class="list-unstyled">
                        <li><span>1</span>Innovative on point & personalized system that reveals your life's problems</li>
                        <li><span>2</span>Readings with your horoscope sign experts</li>
                        <li><span>3</span>24/7 support and answers</li>
                        <li><span>4</span>Secured & <strong>100% confidential</strong></li>
                    </ul>
                </div>
                <div class="col col-sm-6">
                    <p>Live Cosmos is the largest and most efficient system to unfold your life. Our on point, innovative technology along with personalized readers allows us to reveal everything that blocks you from being where you want to be in life.</p>
                    <div class="review">
                        <img src="./images/5-star-review.png" alt=""/>
                        <span>5 Stars Review</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection