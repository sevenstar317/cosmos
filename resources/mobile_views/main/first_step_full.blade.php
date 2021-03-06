@extends('layouts.app')

@section('content')

    <div id="first_step_outer">
    <section class="hero-section" >
        <div class="container">
            <h1 class="title text-center">Live Personalized Astrology & Life Analysis</h1>
            <h4 class="subtitle text-center">Get the right answers to all your life's questions!</h4>

            <div class="progress-wrapper">
                <div class="clearfix">
                    <div class="pull-right time-remaining"><span>Time Remaining:</span> 00:00:<span id="timer">15</span></div>
                </div>
                <div id="connectionProgressId" class="progress"  data-toggle="tooltip" data-placement="top" title="Confirmed and Trusted Connection">
                    <div class="progress-bar" id="connectionProgressBar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" ></div>
                </div>
            </div>
        </div>
    </section>
    </div>
    <div id="second_step_outer" class="no-display-visibility">
            <section class="hero-start-section text-center " id="second_step">
                <div class="toll-free">
                    <img src="./images/toll-free.png" alt=""/>
                    <span>Toll Free 1-866-994-5907</span>
                </div>
                <h2 class="title">Personalized Astrology Live Chat!</h2>
                <h3 class="subtitle">Cosmos Map Based on your Name, Location, DOB, TOB and More!</h3>

                <form action="/register2" method="GET"  role="form" class="form form-inline signup-form">
                    <div class="form-group">
                        <input type="text" class="form-control input-lg" onkeydown="$(this).css('border','0');" style="color:black;border: 1px solid red;background-color: white;" required name="first_name" id="first_name"  placeholder="First Name"/>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control input-lg" style="background-color: white;" required name="last_name" id="last_name" placeholder="Last Name"/>
                    </div>
                    <button type="submit" style="width: 150px;font-weight: bold;" class="btn btn-lg btn-success btn-green btn-start">Start</button>
                </form>
            </section>

        <div class="modal fade" id="request-processing-modal-id" tabindex="-1" role="dialog" aria-labelledby="request-processing-modal-label">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <h3><img src="./images/loading.png" alt=""/> Processing Your Request</h3>
                        <h4>Please Wait...</h4>
                    </div>
                    <div class="modal-footer">
                        <div class="progress-wrapper" style="margin-top: 20px;">
                            <div class="clearfix">
                                <div class="pull-left time-remaining secured-connection"><i class="fa fa-lock"></i> Secured Connection</div>
                                <div class="pull-right time-remaining"><span>Time Remaining:</span> 00:00:<span id="timer">10</span></div>
                            </div>
                            <div id="connectionProgressId" class="progress" >
                                <div class="progress-bar" id="connectionProgressBar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" ></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <section class="questions-section">
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
    <section class="special-advisors-section">
        <h1 class="title text-center"><span>Sign Based Chat Advisors</span> to Match Your Horoscope Sign & Birth Date!</h1>
        <div class="container">
            <div class="row">
                <div class="col col-sm-4">
                    <div class="advisor-container text-center">
                        <img src="./images/logo.png" alt="" class="img-responsive"/>
                        <div class="advisor-image">
                            <img src="/images/goni.jpg" alt="" class="img-responsive"/>
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
                            <img src="./images/iris.jpg" alt="" class="img-responsive"/>
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
                            <img src="./images/anna.jpg" alt="" class="img-responsive"/>
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
    <section class="testimonials-section">
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
    <section class="why-livecosmos-section">
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
    <section class="start-section-redes text-center">
        <div class="container">
            <h1 class="title">Reveal Everything You Need to Know to Turn Your Life Around!</h1>
            <h4 class="subtitle">Decoding the Cosmos to Happiness, Love & Truth</h4>
            <a href="" onclick="event.preventDefault();$('html, body').animate({scrollTop : 0},800);"  class="btn bnt-success btn-start">Start Now</a>
        </div>
    </section>
@endsection