@extends('layouts.app')

@section('content')
    <section class="hero-section signup-map-section">
        <div class="container">
            <h1 class="headline text-center"><i class="fa fa-check-circle-o"></i> Mapping Cosmos for <span style="text-transform: capitalize">{{ $user->first_name }} {{ $user->last_name }}</span> is Complete!</h1>
            <div class="section-inner top">
                <div class="clearfix">
                    <div class="col col-sm-5">
                        <p class="title">Create Your <span>FREE</span> Account Now. Your Map Specialist Awaits You!</p>
                        {!! Form::model($user, ['action' => 'MainController@checkout','class'=>'form']) !!}
                            {{ Form::hidden('registration_token', $registration_token,['id'=>'registration_token']) }}

                              @if($errors->any())
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}<br>
                                    @endforeach
                                </div>
                            @endif
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                {!! Form::text('first_name', $user->first_name, ['placeholder' => 'First Name', 'class'=>"form-control", 'style'=>'color:black', 'required' => 'true']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::text('last_name', $user->last_name, ['placeholder' => 'Last Name', 'class'=>"form-control",'style'=>'color:black', 'required' => 'true']) !!}
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" id="email_pop" style="color:black;border: 1px solid red;background-color: #f2dede" data-toggle="popover" data-placement="bottom" data-content="Please enter an email." required="required"  class="form-control" placeholder="Email"/>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success btn-block btn-lg btn-green">Continue</button>
                            </div>
                        </form>

                    </div>
                    <div class="col col-sm-7">
                        <div class="clearfix member-info">
                            <p class="member-name">{{ $user->first_name }} {{ $user->last_name }}</p>
                            <p class="member-age"> {{ $user->getAge() }} Years Old</p>
                            <p class="member-sign"><span>Sign:</span>  {{ $user->sign }} </p>
                            <p class="member-dob"><span>DOB:</span> {{ $user->monthNumber() }}/{{ $user->birth_day }}/{{ $user->birth_year }}</p>
                            <p class="member-tob"><span>Time of Birth:</span>  {{ $user->birth_time }} </p>
                        </div>
                        <div class="clearfix">
                            <ul class="list-unstyled col col-sm-4">
                                <li><img src="./images/green-star-icon.png" alt=""> Love</li>
                                <li><img src="./images/green-star-icon.png" alt=""> Relationships</li>
                                <li><img src="./images/green-star-icon.png" alt=""> Career</li>
                            </ul>
                            <ul class="list-unstyled col col-sm-4">
                                <li><img src="./images/green-star-icon.png" alt=""> Money</li>
                                <li><img src="./images/green-star-icon.png" alt=""> Family</li>
                                <li><img src="./images/green-star-icon.png" alt=""> Health</li>
                            </ul>
                            <ul class="list-unstyled col col-sm-4">
                                <li><img src="./images/green-star-icon.png" alt=""> Obstacles</li>
                                <li><img src="./images/green-star-icon.png" alt=""> Future</li>
                                <li><img src="./images/green-star-icon.png" alt=""> Direction</li>
                            </ul>
                        </div>
                        <div class="clearfix testimonials-carousel">
                            <div id="testimonials-carousel" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    <li data-target="#testimonials-carousel" data-slide-to="0" class="active"></li>
                                    <li data-target="#testimonials-carousel" data-slide-to="1"></li>
                                </ol>
                                <div class="carousel-inner" role="listbox">
                                    <div class="item clearfix active">
                                        <div class="col col-xs-3">
                                            <img class="img-responsive" src="./images/avatar.png" alt=""/>
                                        </div>
                                        <div class="col col-xs-9 review-details">
                                            <span class="review-text">"I could not believe my eyes when I read what my advisor wrote! Thank You for giving me the points to turn my life around."</span>
                                            <span class="review-author">Nichole S.</span>
                                        </div>
                                    </div>
                                    <div class="item clearfix">
                                        <div class="col col-xs-3">
                                            <img class="img-responsive" src="./images/avatar.png" alt=""/>
                                        </div>
                                        <div class="col col-xs-9 review-details">
                                            <span class="review-text">"We are all affected by energy. Live Cosmos reveals everything that blocks you in life by analyzing your DOB and Name."</span>
                                            <span class="review-author">Mary V.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section-inner bottom">
                <div class="row privacy-block">
                    <div class="col col-sm-6">
                        <h4>WE RESPECT YOUR PRIVACY</h4>
                        <p>All chats and discussions are 100% confidential and we will NEVER share your information!</p>
                    </div>
                    <div class="col col-sm-6 text-center">
                        <img src="./images/secure-image-1.png" alt=""/>
                        <img src="./images/secure-image-2.png" alt=""/>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script type='text/javascript' src='/liveactor/liveactor.js'></script>
    <script type='text/javascript' src='/liveactor/swfobject.js'></script>

    <?php $firefox = isset($_SERVER["HTTP_USER_AGENT"]) && strpos($_SERVER["HTTP_USER_AGENT"], 'Firefox') ? true : false; ?>
    <?php  if(!$firefox): ?>
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
    </script>
    <?php endif; ?>
@endsection