@extends('layouts.app')

@section('content')
    <div class="modal fade" id="request-processing-modal-id" tabindex="-1" role="dialog" aria-labelledby="request-processing-modal-label">
        <div class="modal-dialog" id="not-resize" role="document" >
        <div class="modal-content">
            <div class="modal-body text-center">
                <h3><img src="./images/loading.png" alt=""/> Processing Your Request</h3>
                <h4>Please Be Patient...</h4>
            </div>
            <div class="modal-footer">
                <div class="progress-wrapper" style="margin-top: 20px;">
                    <div class="clearfix">
                        <div class="pull-left time-remaining secured-connection"><i class="fa fa-lock"></i> Secured Connection</div>
                        <div class="pull-right time-remaining"><span>Time Remaining:</span> 00:00:<span id="timer2">10</span></div>
                    </div>
                    <div id="connectionProgressId" class="progress" >
                        <div class="progress-bar" id="connectionProgressBar2" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" ></div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
    <section class="hero-section connecting-section">

        <div class="container">
            <div class="connecting-inner text-center">
                {{ Form::hidden('registration_token', $registration_token,['id'=>'registration_token']) }}
                <div class="spinner-wrapper">
                    <div class="spinner-animation"></div>
                    <div class="spinner-text">
                        <span>Connecting</span>to a {{ $user->sign }}<br/>Specialist
                    </div>
                </div>
                <div class="progress-wrapper">
                    <div class="clearfix">
                        <div class="pull-right time-remaining"><span>Time Remaining:</span> 00:00:<span id="timer">45</span></div>
                    </div>
                    <div id="connectionProgressId" class="progress">
                        <div  class="progress-bar" id="connectionProgressBar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
            <?php switch($user->sign){
                case 'Aries':
                    $question1 = 'Do you have a Strong Will and can be Self Centered about pursing it? ';
                    $question2 = ' Would you say you have Self Discipline? ';
                    break;
                case 'Taurus':
                    $question1 = 'Would you say you are a practical individual? ';
                    $question2 = ' Would you say you have a large capacity for kindness? ';
                    break;
                case 'Gemini':
                    $question1 = 'Do you tend towards liberty in relationships? ';
                    $question2 = 'Are you easily easily bored? ';
                    break;
                case 'Cancer':
                    $question1 = 'Do you tend to collect the residue of past experience and hold on to it? ';
                    $question2 = 'Are you likely to reflect the mood of those around you?';
                    break;
                case 'Leo':
                    $question1 = 'Do you tend to be overly proud at times? ';
                    $question2 = 'Are you determined and usually get your own way when you really want something? ';
                    break;
                case 'Virgo':
                    $question1 = 'Do you like the joy that come from hard work? ';
                    $question2 = 'Would you say you have perfectionist tendencies?  ';
                    break;
                case 'Libra':
                    $question1 = 'In disputes, would you say you have the tendency to understand and support both sides?  ';
                    $question2 = 'Would you say you will go out of your way to avoid quarrel? ';
                    break;
                case 'Scorpio':
                    $question1 = 'Are you a shrewd judge of other people’s motives? ';
                    $question2 = 'Would you say you are able to transform your pain into self empowerment? ';
                    break;
                case 'Sagittarius':
                    $question1 = 'Would you say you are curious about the world around you? ';
                    $question2 = 'Do you often get into trouble for being too blunt?  ';
                    break;
                case 'Capricorn':
                    $question1 = 'Do you put yourself under enormous pressure to perform? ';
                    $question2 = 'Do you often feel personally responsible for those around you? ';
                    break;
                case 'Aquarius':
                    $question1 = 'Would you say you are Intuitive, Inventive and inclined to take chances, especially in service of your goals? ';
                    $question2 = ' Do you often come across as Critical or Demanding? ';
                    break;
                case 'Pisces':
                    $question1 = 'Do you often find yourself to be stronger then you thought you could be?';
                    $question2 = 'Would you say you react to situations in a way that can affect your mood instantly? ';
                    break;

            } ?>


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



@endsection