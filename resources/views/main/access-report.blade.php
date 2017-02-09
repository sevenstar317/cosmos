@extends('layouts.app')

@section('content')
    <div class=" website-content">
    <section class="hero-section wait-report-section" style="background:url(../images/hero-bg.jpg) no-repeat center center;background-size: cover;">
        <h1 class="headline text-center">Please Wait While We Map Our Report
            On <span style="text-transform: capitalize">{{ $user->first_name }} {{ $user->last_name }}</span>, {{ $user->sign }}, {{ $user->birth_month }} {{ $user->birth_day }}, {{ $user->birth_year }}, {{ $user->birth_time }}</h1>

            {{ Form::hidden('registration_token', $registration_token,['id'=>'registration_token']) }}
            <ul class="steps-list-rich text-center list-inline list-unstyled">
                <li >
                    <div id="connectionProgressId" data-placement="top">
                        <img src="./images/step-rich-1.png" alt=""/>

                        <p>Love</p>

                        <div class="progress-vertical" id="connectionProgressBar2" data-title="Love Horoscopes"
                             data-info="Love can be complicated. There are up and downs in any relationship. The main issue most people face in their love relationship is that they feel misunderstood, miscommunication, they grow apart from their loved on. Unlocking your personal map will help you reveal some key points about things you should and/or should not do during in your love relationship."
                             role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="120"></div>
                    </div>
                </li>

                <li >
                    <div id="connectionProgressId" data-placement="top">
                        <img src="./images/step-rich-2.png" alt=""/>

                        <p>Relationships</p>

                        <div class="progress-vertical" id="connectionProgressBar2" data-title="Relationships Horoscopes"
                             data-info="Love can be complicated. There are up and downs in any relationship. The main issue most people face in their love relationship is that they feel misunderstood, miscommunication, they grow apart from their loved on. Unlocking your personal map will help you reveal some key points about things you should and/or should not do during in your love relationship."
                             role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="120"></div>
                    </div>
                </li>

                <li >
                    <div id="connectionProgressId" data-placement="top">
                        <img src="./images/step-rich-3.png" alt=""/>

                        <p>Money</p>

                        <div class="progress-vertical" id="connectionProgressBar2" data-title="Money Horoscopes"
                             data-info="To most people money is a big deal. How is it that some have more than others, are some people born luckier? Why is it that one person can hold on to their wealth and others can not? When is the best time to make a financial investment? Unlock your map to better understand how handle certain financial situations."
                             role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="120"></div>

                    </div>
                </li>
                <li >
                    <div id="connectionProgressId" data-placement="top">
                        <img src="./images/step-rich-4.png" alt=""/>

                        <p>Career</p>

                        <div class="progress-vertical" id="connectionProgressBar2" data-title="Career Horoscopes"
                             data-info="How do we know if the career we chose is the right career for us? Should we stay in our current job? Should we follow our dream and start our own business? Your numerology readings helps you better direct your life and career! "
                             role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="120"></div>
                    </div>
                </li>

                <li >
                    <div id="connectionProgressId" data-placement="top">
                        <img src="./images/step-rich-5.png" alt=""/>

                        <p>Family</p>

                        <div class="progress-vertical" id="connectionProgressBar2" data-title="Family Horoscopes"
                             data-info="Why are there so many tough situations in one family and another has it a lot easier? Why are some families find it a lot easier to keep it together than others? Why do I have a difficult time getting along with family members? Your personal astrology readings sheds light on all these questions and more!"
                             role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="120"></div>
                    </div>
                </li>
                <li>
                    <div id="connectionProgressId" data-placement="top">
                        <img src="./images/step-rich-6.png" alt=""/>

                        <p>Health</p>

                        <div class="progress-vertical" id="connectionProgressBar2" data-title="Health Horoscopes"
                             data-info="Why are there so many tough situations in one family and another has it a lot easier? Why are some families find it a lot easier to keep it together than others? Why do I have a difficult time getting along with family members? Your personal astrology readings sheds light on all these questions and more!"
                             role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="120"></div>
                    </div>
                </li>
                <li >
                    <div id="connectionProgressId" data-placement="top">
                        <img src="./images/step-rich-7.png" alt=""/>

                        <p>Past & Future</p>

                        <div class="progress-vertical" id="connectionProgressBar2" data-title="Past & Future Horoscopes"
                             data-info="How is it that some people find it much easier to move forward from problems while others stay stuck behind and linger on relationships, issues and other problems for years. Your numerology reading can explain a lot about your issues with moving on from your past."
                             role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="120"></div>
                    </div>
                </li>
                <li >
                    <div id="connectionProgressId" data-placement="top">
                        <img src="./images/step-rich-8.png" alt=""/>

                        <p>Obstacles</p>

                        <div class="progress-vertical" id="connectionProgressBar2" data-title="Obtacles Horoscopes"
                             data-info="Life obstacles happen all the time. We do not have to do much and life just happens and obstacles occur. Understanding your personal map can shed light on how to deal with your life obstacles and problems."
                             role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="120"></div>
                    </div>
                </li>
            </ul>

        <div class="container">
            <div class="wait-report-inner">
                <p class="horoscope-title text-center">Love Horoscopes</p>

                <p class="horoscope-text text-center">
                    Love can be complicated. There are up and downs in any relationship. The main issue most people face
                    in their love relationship is that they feel misunderstood, miscommunication, they grow apart from
                    their loved on. Unlocking your personal map will help you reveal some key points about things you
                    should and/or should not do during in your love relationship.
                </p>

                <?php switch($user->sign){
                    case 'Aries':
                        $question1 = 'Would you consider yourself to be an Energetic person like many Aries people?';
                        $question2 = 'Do you rush into things before reflecting in most cases?';
                    break;
                    case 'Taurus':
                        $question1 = 'Do you enjoy the comfort of your home environment? ';
                        $question2 = 'Do you appear to be quiet on the surface to most people? ';
                        break;
                    case 'Gemini':
                        $question1 = 'Would you say you have a Logical thought process?';
                        $question2 = 'Do you engage in many varied experiences to gain knowledge?';
                        break;
                    case 'Cancer':
                        $question1 = 'Would you say you are a Nurturing individual?';
                        $question2 = 'Do you find yourself often involved with the past in some way?';
                        break;
                    case 'Leo':
                        $question1 = 'Do you tend to express yourself in a dramatic, creative, assertive ways? ';
                        $question2 = 'Would those who know you say that you have great integrity?';
                        break;
                    case 'Virgo':
                        $question1 = 'Are you very conscious of details? ';
                        $question2 = 'Would you say you like to gain and share knowledge about different things in life? ';
                        break;
                    case 'Libra':
                        $question1 = 'Would you say you are a seeker of harmony and beauty in life? ';
                        $question2 = 'Do you find intimate relationships to be of importance to you?';
                        break;
                    case 'Scorpio':
                        $question1 = 'Would you say you have great powers of Persuasion?';
                        $question2 = 'Do you have a Strong Will that lets nothing stand in your way? ';
                        break;
                    case 'Sagittarius':
                        $question1 = 'Would you say you are direct and forthright individual? ';
                        $question2 = 'Do you gravitate towards adventure, sports and travel and/or any other form of risk taking? ';
                        break;
                    case 'Capricorn':
                        $question1 = 'Do you feel like you have a great sense of social responsibility? ';
                        $question2 = 'Would you say that you can be insecure at times? ';
                        break;
                    case 'Aquarius':
                        $question1 = 'Would you say you have a rebellious nature?';
                        $question2 = 'Do you often feel like you are years ahead of your time in the way you think? ';
                        break;
                    case 'Pisces':
                        $question1 = 'Would you describe yourself as dreamy and full of imagination? ';
                        $question2 = 'Do you have an artistic temperament that allows you to express your feelings in creative and innovative ways?';
                        break;

                } ?>


            </div>

            <div class="progress-wrapper">
                <div class="clearfix">
                    <div class="pull-right time-remaining"><span>Time Remaining:</span> 00:00:<span id="timer">59</span>
                    </div>
                </div>
                <div id="connectionProgressId" class="progress">
                    <div class="progress-bar" id="connectionProgressBar"  style="text-align: center"; role="progressbar" aria-valuenow="0"
                         aria-valuemin="0" aria-valuemax="100">Processing 0%</div>
                </div>
            </div>
        </div>
    </section>

        <!-- Modal -->
        <div class="modal fade personal-1" id="personal-question-modal-id" tabindex="-1" role="dialog" aria-labelledby="personal-question-modal-label">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="clearfix">
                        <div class="col col-sm-3 personal-question-head">
                            <p>Horoscope <br/>Personality Question</p>
                            <img src="./images/horoscope-{{strtolower($user->sign)}}.png" class="img-responsive" alt=""/>
                        </div>
                        <div class="col col-sm-9 personal-question-body">
                            <p>{{$question1}}</p>
                            <ul class="list-unstyled list-inline">
                                <li><button class="btn btn-lg btn-success" name="yes1" onclick="
                            $('.personal-1').hide();
                            $('#thankyou-msg-modal-id').modal({backdrop: false});
                            setTimeout(function(){
                               $('#thankyou-msg-modal-id').fadeOut();
                            }, 2000);
                            setTimeout(function(){
                                $('.personal-2').modal({backdrop: false});
                            }, 5000)
                            ">Yes</button></li>
                                <li><button class="btn btn-lg btn-danger" onclick="
                            $('.personal-1').hide();
                            $('#thankyou-msg-modal-id').modal({backdrop: false});
                            setTimeout(function(){
                              $('#thankyou-msg-modal-id').fadeOut();
                            }, 2000);
                            setTimeout(function(){
                                $('.personal-2').modal({backdrop: false});
                            }, 5000)">No</button></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade personal-2" id="personal-question-modal-id" tabindex="-1" role="dialog" aria-labelledby="personal-question-modal-label">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="clearfix">
                        <div class="col col-sm-3 personal-question-head">
                            <p>Horoscope <br/>Personality Question</p>
                            <img src="./images/horoscope-{{strtolower($user->sign)}}.png" class="img-responsive" alt=""/>
                        </div>
                        <div class="col col-sm-9 personal-question-body">
                            <p>{{$question2}}</p>
                            <ul class="list-unstyled list-inline">
                                <li><button class="btn btn-lg btn-success" name="yes2" onclick="$('.personal-2').hide();$('#thankyou-msg-modal-id').modal({backdrop: false});setTimeout(function(){
                        $('#thankyou-msg-modal-id').fadeOut();
                        }, 2000); ">Yes</button></li>
                                <li><button class="btn btn-lg btn-danger" onclick="$('.personal-2').hide();$('#thankyou-msg-modal-id').modal({backdrop: false});setTimeout(function(){
                        $('#thankyou-msg-modal-id').fadeOut();
                        }, 2000); ">No</button></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="thankyou-msg-modal-id" tabindex="-1" role="dialog" aria-labelledby="thankyou-msg-modal-label">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <h1 class="headline">
                        <img src="./images/ok-white-icon.png" alt=""/> Thank You. We are Analyzing Your Map!
                    </h1>
                </div>
            </div>
        </div>


        <div class="container report-privacy-block">
        <div class="clearfix privacy-block">
            <div class="col col-sm-6">
                <h4>WE RESPECT YOUR PRIVACY</h4>
                <p>All chats and discussions are 100% confidential and we will NEVER share your information!</p>
            </div>
            <div class="col col-sm-6 text-center">
                <img src="./images/secure-image-1.png" alt=""/>
                <img src="./images/secure-image-2.png" alt=""/>
            </div>
        </div>
    </div></div>
@endsection