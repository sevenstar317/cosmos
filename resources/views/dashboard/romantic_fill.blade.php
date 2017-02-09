@extends('layouts.dashboard')

<?php use Collective\Html\FormFacade as Form; ?>

@section('content')
    <div class="clearfix livechat-container">

        @include('layouts._dashboard_left_menu_for_report')

        <div class="col col-sm-10 livechat-content">
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane my-cosmos-tab text-center  active" id="my-cosmos">
            <div class="my-cosmos-headline text-center">
                <h3 class="my-cosmos-title">Romantic Compatibility Report</h3>
                <h4 class="my-cosmos-subtitle">Enter Information to Get Results</h4>
            </div>
            <div class="inner-pane-padding">
                <div class="romantic-compatibility-report text-left">
                    {!! Form::model($user, ['action' => 'DashboardController@fillRomantic']) !!}

                        {{ csrf_field() }}
                        @if($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}<br>
                                @endforeach
                            </div>
                        @endif
                        <div class="clearfix">
                            <div class="col col-sm-6 form-column">
                                <h4>My Information:</h4>

                                <div class="form-group">
                                    <input type="text" class="form-control input-lg" placeholder="First Name" value="{{$user->first_name}}" readonly/>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control input-lg" placeholder="Last Name" value="{{$user->last_name}}" readonly/>
                                </div>
                                <div class="form-group">
                                    <div class="input-group date" id="">
                                        <input type="text"  value="{{$user->getBirthday()}}" readonly  class="form-control input-lg" placeholder="Birth Date">
                                                <span class="input-group-addon">
                                                    <span class="fa fa-chevron-down"></span>
                                                </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Time of Birth</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control input-lg" placeholder="Birth Time" value="{{$user->birth_time}}" readonly/>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> Sunrize <i class="fa fa-question-circle" aria-hidden="true"></i>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col col-xs-8">
                                            <label for="">State</label>
                                            <input type="text" class="form-control input-lg" value="{{$user->state}}" readonly placeholder="State"/>

                                        </div>
                                        <div class="col col-xs-4">
                                            <label for="">Location of Birth</label>
                                            <input type="text" class="form-control input-lg" value="{{$user->city}}" readonly placeholder="City"/>

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col col-xs-8">
                                            <input type="text" class="form-control input-lg" value="USA" readonly placeholder="Country"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col col-xs-8">
                                            <label for="">State</label>
                                            <input autocomplete="off" type="text" placeholder="State" required data-provide="typeahead" value="{{old('c_state')?:$user->c_state}}" class="form-control  input-lg" name="c_state" id="state" />

                                        </div>
                                        <div class="col col-xs-4">
                                             <label for="">Current location</label>
                                            <input type="text" name="c_city" value="{{ old('c_city')?:$user->c_city }}" required  readonly="true" id="city" class="form-control input-lg" placeholder="City (select state first)"/>

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col col-xs-8">
                                            <input type="text" class="form-control input-lg" placeholder="Country" value="USA" readonly/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col col-sm-6 form-column">
                                <h4>My Partner's Information:</h4>
                                <div class="form-group">
                                    <input type="text" class="form-control input-lg" name="first_name"  value="{{old('first_name')?:$second_user->first_name}}" required placeholder="First Name"/>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control input-lg" name="last_name"  value="{{old('last_name')?:$second_user->last_name}}" required placeholder="Last Name"/>
                                </div>
                                <div class="form-group">
                                    <div class="input-group date" id="">
                                        <input type="text" id="datepn"  name="birth_month"  class="form-control input-lg" {{old('birth_month')?:$second_user->birth_month}} required placeholder="Birth Date">
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
                            <button type="submit" class="btn btn-lg btn-success btn-green btn-generate">generate</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
        </div>
    </div>
@endsection