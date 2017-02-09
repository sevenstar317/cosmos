@extends('layouts.app')

@section('content')
    <section class="hero-section signup-map-section">
        <div class="container">

            <div class="col col-sm-12" >
                <div class="clearfix member-info" style="background-color: white;">
                    <p class="member-name">{{ $user->first_name }} {{ $user->last_name }}</p>
                    <p class="member-age"> {{ $user->getAge() }} Years Old</p>
                    <p class="member-sign"><span>Sign:</span>  {{ $user->sign }} </p>
                    <p class="member-dob"><span>DOB:</span> {{ $user->monthNumber() }}/{{ $user->birth_day }}/{{ $user->birth_year }}</p>
                    <p class="member-tob"><span>Time of Birth:</span>  {{ $user->birth_time }} </p>
                </div>
            </div>
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
                                <input type="email" name="email" id="email_pop" style="color:black;border: 1px solid red;background-color: #f2dede" data-toggle="popover" data-placement="bottom" data-content="Please enter an email."required  class="form-control" placeholder="Email"/>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success btn-block btn-lg btn-green">Continue</button>
                            </div>
                        </form>
                        </div>

                    <div class="col col-sm-5">
                        <div class="col col-sm-12" style="padding-left: 0px;padding-right: 0px;padding-bottom: 10px;padding-top: 0px;">
                            <div class="advisor-container text-center">
                                <div class="advisor-image">
                                    <img src="./images/anna.jpg" style="height:255px;width:auto;" alt="" class="img-responsive"/>
                                </div>
                                <div class="advisor-name">Anna</div>

                            </div>
                        </div>
                    </div>
                    <div class="col col-sm-7">

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
@endsection