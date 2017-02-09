@extends('layouts.dashboard')

<?php use Collective\Html\FormFacade as Form; ?>

@section('content')
    <div class="clearfix livechat-container">

        @include('layouts._dashboard_left_menu_for_report')

        <div class="col col-sm-10 livechat-content">
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane my-cosmos-tab text-center  active" id="my-cosmos">
            <div class="my-cosmos-headline text-center">
                <h3 class="my-cosmos-title">{{$desc}} Report</h3>
                <h4 class="my-cosmos-subtitle">Enter Information to Get Results</h4>
            </div>
            <div class="inner-pane-padding">
                <div class="romantic-compatibility-report text-left">
                    {!! Form::model($user, ['id'=>'report_form','action' => ['DashboardController@fillNormal' ,$sku]]) !!}

                        {{ csrf_field() }}
                        @if($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}<br>
                                @endforeach
                            </div>
                        @endif
                        <div class="clearfix">

                            <div class="col col-sm-12 form-column">
                                <h4>Information:</h4>
                                <div class="form-group">
                                    <input type="text" class="form-control input-lg" name="first_name"  value="{{old('first_name')?:$second_user->first_name}}" required placeholder="First Name"/>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control input-lg" name="last_name"  value="{{old('last_name')?:$second_user->last_name}}" required placeholder="Last Name"/>
                                </div>
                                <div class="form-group">
                                    <div class="input-group date" id="">
                                        <input type="text"  name="birth_month"  id="datepn" class="form-control input-lg" {{old('birth_month')?:$second_user->birth_month}} required placeholder="Birth Date">
                                                <span class="input-group-addon">
                                                    <span class="fa fa-chevron-down"></span>
                                                </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Time of Birth</label>
                                    <div class="row">
                                        <div class="col col-xs-4">
                                            <select name="birth_time_hour" id="" class="form-control">
                                                @for($i = 1; $i < 13; $i++)
                                                    <option value="{{$i}}">{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="col col-xs-4">
                                            <select name="birth_time_minute" id="" class="form-control">
                                                @for($i = 1; $i < 60; $i++)
                                                    <option value="{{$i}}">{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="col col-xs-4">
                                            <select  name="birth_time_type"  id="" class="form-control">
                                                <option value="AM">AM</option>
                                                <option value="PM">PM</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input value="{{old('birth_time_sunrise')?:$second_user->birth_time_sunrise}}" name="birth_time_sunrise" type="checkbox"> Sunrize <i class="fa fa-question-circle" aria-hidden="true"></i>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col col-xs-8">
                                            <label for="">State</label>
                                            <input autocomplete="off" type="text" placeholder="State"  value="{{old('state')?:$second_user->state}}"  required data-provide="typeahead" class="form-control  input-lg" name="state" id="state1" />

                                        </div>
                                        <div class="col col-xs-4">
                                             <label for="">Location of Birth</label>
                                            <input type="text" name="city" id="city1"  value="{{old('city')?:$second_user->city}}" readonly="true"  class="form-control input-lg" required placeholder="City (select state first)"/>

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col col-xs-8">
                                            <input type="text" class="form-control input-lg"  placeholder="Country" value="USA" readonly/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col col-xs-8">
                                            <label for="">State</label>
                                            <input autocomplete="off" type="text" placeholder="State"  value="{{old('s_c_state')?:$second_user->s_c_state}}"  required data-provide="typeahead"  class="form-control  input-lg" name="s_c_state" id="state2" />

                                        </div>
                                        <div class="col col-xs-4">
                                            <label for="">Current location</label>
                                            <input type="text" name="s_c_city"  id="city2" value="{{old('s_c_city')?:$second_user->s_c_city}}"  readonly="true" required class="form-control input-lg" placeholder="City (select state first)"/>

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col col-xs-8">
                                            <input type="text" class="form-control input-lg"  placeholder="Country" value="USA" readonly/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix text-center">
                            <button id="submit_new_report" onclick="event.preventDefault(); $('.personal-map-new-modal-id').modal();" class="btn btn-lg btn-success btn-green btn-generate">generate</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
        </div>
    </div>
    <!-- Personal astro Modal -->
    <div class="modal fade personal-map-new-modal-id" id="personal-map-modal-id" tabindex="-1" role="dialog"
         aria-labelledby="personal-map-modal-label">
        <div class="modal-dialog" role="document">
            <div class="modal-content text-center">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Personal Astrology Map Report</h4>
                </div>
                <div class="modal-body">
                    <img src="/images/personal-map-modal.png" alt=""/>

                    <div class="headline">Get the most detailed and personal Astrology map analysis available today! Deepen
                        your self-awareness and introspection with your birth chart and other personal information!
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="" id="buy_natal_report_new" class="btn btn-success btn-green btn-lg">access now</a>

                    <p>You will be charged a one time administrative fee of $19.95 to be able to view your personalized
                        astrology map report. No other charges will be made for this service and you will be able to use
                        view this report.</p>
                </div>
            </div>
        </div>
    </div>
@endsection