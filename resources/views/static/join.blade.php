@extends('layouts.static')

@section('content')
    <div class="top-container">
        <h2 class="footer-page-headline">
            <div class="container">
                <div class="col col-sm-offset-2 col-sm-10">Apply and Join Live Cosmos Advisor Team</div>
            </div>
        </h2>
    </div>
    <div class="container">
        <div class="col col-sm-3 col-md-2">
            <div class="side-links-menu">
                <ul class="list-unstyled clearfix">
                    <li><a href="{{ url('privacy') }}">Privacy</a></li>
                    <li><a href="{{ url('terms') }}">Terms</a></li>
                    <li><a href="{{ url('contact') }}">Contact</a></li>
                    <li class="active"><a href="{{ url('join') }}">Join as Advisor</a></li>
                </ul>
            </div>
        </div>

        <div class="col col-sm-9 col-md-10">
            <div class="bottom-container">
                <div class="container">
                    {!! Form::open(['route' => ['user.join-advisor'],'class'=> 'form', 'id'=>'contact_join']) !!}
                    <div class="row">
                        <div class="col col-sm-6 col-md-5">
                            <div class="form-group">
                                <input type="text" class="form-control input-lg" name="first_name" required
                                       placeholder="First Name"/>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control input-lg" name="last_name" required
                                       placeholder="Last Name"/>
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control input-lg" name="email" required
                                       placeholder="Email"/>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control input-lg" name="phone" required
                                       placeholder="Phone Number"/>
                            </div>
                        </div>
                        <div class="col col-sm-6 col-md-5">
                            <div class="form-group">
                                <input type="text" class="form-control input-lg" name="address" required
                                       placeholder="Address"/>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" rows="7" name="message" required
                                          placeholder="Why you want to join"></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success btn-green btn-block btn-lg btn-submit">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
@endsection