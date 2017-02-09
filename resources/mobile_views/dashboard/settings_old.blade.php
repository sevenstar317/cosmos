@extends('layouts.dashboard')

<?php use Collective\Html\FormFacade as Form; ?>

@section('content')
    <div class="clearfix livechat-container">

        @include('layouts._dashboard_left_menu')

        <div class="col col-sm-10 livechat-content">
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane my-cosmos-tab text-center" id="my-cosmos">
            <div class="my-cosmos-topline">
                <div class="spinner-static">
                    <i class="fa fa-check-circle" aria-hidden="true"></i>
                    <span>Successful<br/>Updated!</span>
                </div>
                <p>Your Next Map Update Is:<br/>{{Date('m/d/Y', strtotime("+3 days"))}}</p>
            </div>
            <div class="my-cosmos-headline text-center">
                <h3 class="my-cosmos-title">My Personal Information</h3>
            </div>
            <div class="cosmos-comb-summary">
                <ul class="list-inline list-unstyled text-center">
                    <li>
                        <div>
                            <img src="/images/cosmos-sum-1.png" alt=""/>
                            <span>{{$user->getFullName()}}</span>
                        </div>
                    </li>
                    <li>
                        <div>
                            <img src="/images/cosmos-sum-2.png" alt=""/>
                            <span>{{$user->sex}}</span>
                        </div>
                    </li>
                    <li>
                        <div>
                            <img src="/images/cosmos-sum-3.png" alt=""/>
                            <span>{{$user->getBirthday()}}</span>
                        </div>
                    </li>
                    <li>
                        <div>
                            <img src="/images/cosmos-sum-4.png" alt=""/>
                            <span>{{$user->sign}}</span>
                        </div>
                    </li>
                    <li>
                        <div>
                            <img src="/images/cosmos-sum-5.png" alt=""/>
                            <span>{{$user->birth_time}}</span>
                        </div>
                    </li>
                    <li>
                        <div>
                            <img src="/images/cosmos-sum-6.png" alt=""/>
                            <span>{{ $user->city }}, {{ $user->state }}</span>
                        </div>
                    </li>
                </ul>
            </div>


            <!-- MY COSMOS -->
            <div class="my-cosmos-headline text-center"></div>
            <div class="inner-pane-padding">
                <!--

                <div class="row text-center scheduled-horoscopes">
                    <div class="col col-sm-6">
                        <div class="inner">
                            <h4 class="headline">Daily Horoscope:</h4>
                            <div class="horoscope-dates">08/09/2016</div>
                            <p class="text-left">Lorem ipsum dolor sit amet, nusquam tincidunt in has, eu mei nonumes expetenda laboramus. Usu et dico vero ceteros. An ius hinc dolorum legendos, sit in inimicus posidonium, qui ad error zril senserit. Mundi oporteat eam ut, sea cu graece semper... <a href="">see more</a></p>
                        </div>
                    </div>
                    <div class="col col-sm-6">
                        <div class="inner">
                            <h4 class="headline">Weekly Horoscope:</h4>
                            <div class="horoscope-dates">08/09/2016 - 08/15/2016</div>
                            <p class="text-left">Lorem ipsum dolor sit amet, nusquam tincidunt in has, eu mei nonumes expetenda laboramus. Usu et dico vero ceteros. An ius hinc dolorum legendos, sit in inimicus posidonium, qui ad error zril senserit. Mundi oporteat eam ut, sea cu graece semper... <a href="">see more</a></p>
                        </div>
                    </div>
                </div>

                 -->
                <div class="clearfix cosmos-redirect-links">
                    <ul class="list-unstyled">
                        <li class="clearfix">
                            <div class="clearfix img-wrapper">
                                <img class="img-responsive" src="/images/redirect-link-1.png" alt=""/>
                            </div>
                            <p class="pull-left">Personal Astrology Map</p>
                            <a href="/dashboard/show-report/natal" style="width: 150px;" <?php echo !$user->getNatalReport()? 'onclick="event.preventDefault();$(\'#personal-map-modal-id\').modal();"' : '' ?> id="personal_buy" class="btn btn-green btn-success btn-lg pull-right">
                                <?php echo $user->getNatalReport()? "View Now" : 'Access' ?>
                            </a>
                        </li>
                        <li class="clearfix">
                            <div class="clearfix img-wrapper">
                                <img class="img-responsive" src="/images/redirect-link-2.png" alt=""/>
                            </div>
                            <p class="pull-left">Future Forecast Map Report</p>
                            <a href="/dashboard/show-report/future" style="width: 150px;" <?php echo !$user->getFutureReport()? 'onclick="event.preventDefault();$(\'#future-forecast-modal-id\').modal();"' : '' ?> id="future_buy" class="btn btn-green btn-success btn-lg pull-right">
                                <?php echo $user->getFutureReport()? "View Now" : 'Access' ?>
                            </a>
                        </li>

                        <li class="clearfix">
                            <div class="clearfix img-wrapper">
                                <img class="img-responsive" src="/images/redirect-link-3.png" alt=""/>
                            </div>
                            <p class="pull-left">Romantic Compatibility Map Report</p>
                            <a href="" style="width: 150px;" onclick="$('#romantic-map-modal-id').modal();" id="romantic_buy" class="btn btn-green btn-success btn-lg pull-right">Start Now</a>
                        </li>
                    </ul>
                </div>
            </div>


            <!--    <a class="btn btn-lg btn-block btn-warning btn-yellow btn-chat" href="">Chat with a Specialist >></a>

           TODO: use this image for non auth users
             <img src="/images/unlock-cosmos.png" alt="" class="img-responsive img-wide"/>
 -->
        </div>

        <div role="tabpanel" class="tab-pane live-chat-tab active" id="live-chat">
            <div class="inner-pane-padding">
            <div class="livechat-wrapper">

                <section ui-view></section>

            </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane account-activity-tab" id="account-activity">
            <form class="form-inline">
                <div class="form-group">
                    <label for="" class="pull-left">Show activity from</label>
                    <div class="input-group date" id="datetimepicker1">
                        <input type="text" class="form-control input-lg" placeholder="07/02/2016">
                                                <span class="input-group-addon">
                                                    <span class="fa fa-chevron-down"></span>
                                                </span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="pull-left">to</label>
                    <div class="input-group date" id="datetimepicker2">
                        <input type="text" class="form-control input-lg" placeholder="08/02/2016">
                                                <span class="input-group-addon">
                                                    <span class="fa fa-chevron-down"></span>
                                                </span>
                    </div>
                </div>
                <div class="clearfix text-center">
                    <div class="form-group">
                        <input type="submit" value="Update" class="btn btn-blue btn-lg btn-primary">
                    </div>
                </div>
            </form>
            <table class="table">
                <thead>
                <tr>
                    <td>Type</td>
                    <td>Date</td>
                    <td>Card Name</td>
                    <td>Last 4 digits</td>
                    <td>Amount</td>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach($paymentHistory as $history){
                    echo "<tr><td>$history->description</td><td>$history->created_at</td><td>".$history->paymentInfo->card_name."</td><td>".substr($history->paymentInfo->card_number,-4,4)."</td><td>$history->total</td></tr>";
                }
                ?>
                <tr>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                </tr>
                </tbody>
            </table>

            <div class="clearfix balance-info text-center">
                <div class="col col-sm-offset-1 col-sm-4 balance-wrapper">
                    <h3>Minutes Balance</h3>
                    <h1 class="balance">{{Auth::user()->minutes_balance}}</h1>

                    <a href="" class="learn-more">(learn more)</a>
                    <div class="pad">
                        <a href="" id="add_funds" class="btn btn-lg btn-success btn-green btn-block">Add Minutes</a>
                    </div>
                </div>
                <div class="col col-sm-offset-2 col-sm-4 refill-status">
                    <h4>Refill Status</h4>
                    <h1 class="off">Off</h1>
                    <div class="pad">
                        <a href="" class="btn btn-lg btn-success btn-green btn-block">Turn On</a>
                    </div>
                    <a href="" class="learn-more">Why should I turn this on?</a>
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane account-settings-tab " id="account-settings">

            @include('dashboard.partials._settings')

        </div>
    </div>
        </div>
    </div>
@endsection