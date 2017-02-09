@extends('layouts.dashboard_mobile')

@section('content')
    <div class="website-content">
        <?php $timer = \App\Models\Timer::find(1); ?>
            <div class="breadcrumbs">
                <ul class="list-unstyled list-inline">
                    <li><a  id="<?php  if(isset(Auth::user()->paymentInfo)){ echo '';} else { echo 'add_payment_info';} ?>"
                            href="<?php  if(isset(Auth::user()->paymentInfo)){ echo '/dashboard/initial';} else { echo '';} ?>"
                           ><i class="fa fa-chevron-left" aria-hidden="true">
                            </i> My Cosmos</a>
                    </li>
                </ul>
            </div>
                    <div class="my-cosmos-topline text-center">
                        <div class="spinner-static">
                            <i class="fa fa-check-circle" aria-hidden="true"></i>
                            <span id="getting-started">Successful<br/>Updated!</span>
                        </div>
                        <p>Your Next Map Update Is:<br/>{{$timer->count_down_date}}</p>
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
                                    <img src="/images/horoscope_images/{{strtolower($user->sign)}}.png" alt=""/>
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
                            <ul class="list-unstyled text-center">
                                <li class="clearfix">
                                    <div class="clearfix img-wrapper">
                                        <img class="img-responsive" src="/images/redirect-link-1.png" alt=""/>
                                    </div>
                                    <p >Personal <br/> Astrology Map</p>
                                    <a href="/dashboard/show-report/Personal-Astrology-Report"
                                       <?php echo !$user->getNatalReport() && isset(Auth::user()->paymentInfo) ? 'onclick="event.preventDefault();$(\'#personal-map-modal-id\').modal();"' : '' ?>
                                       id="<?php  if(isset(Auth::user()->paymentInfo)){ echo 'personal_buy';} else { echo 'add_payment_info';} ?>"
                                       class="btn btn-green btn-success btn-lg ">
                                        <?php echo $user->getNatalReport() ? "View Now" : 'Access' ?>
                                    </a>
                                </li>
                                <li class="clearfix">
                                    <div class="clearfix img-wrapper">
                                        <img class="img-responsive" src="/images/redirect-link-2.png" alt=""/>
                                    </div>
                                    <p >Future Forecast <br/> Map Report</p>
                                    <a href="/dashboard/show-report/Future-Forecast-Report"
                                       <?php echo !$user->getFutureReport() && isset(Auth::user()->paymentInfo) ? 'onclick="event.preventDefault();$(\'#future-forecast-modal-id\').modal();"' : '' ?>
                                       id="<?php  if(isset(Auth::user()->paymentInfo)){ echo 'future_buy';} else { echo 'add_payment_info';} ?>"
                                       class="btn btn-green btn-success btn-lg ">
                                        <?php echo $user->getFutureReport() ? "View Now" : 'Access' ?>
                                    </a>
                                </li>

                                <li class="clearfix">
                                    <div class="clearfix img-wrapper">
                                        <img class="img-responsive" src="/images/redirect-link-3.png" alt=""/>
                                    </div>
                                    <p >Romantic <br/> Compatibility Map</p>
                                    <a href="/dashboard/show-report/Romantic-Report"
                                       <?php echo !$user->getRomanticReport() && isset(Auth::user()->paymentInfo) ? 'onclick="event.preventDefault();$(\'#romantic-map-modal-id\').modal();"' : '' ?>
                                       id="<?php  if(isset(Auth::user()->paymentInfo)){ echo 'romantic_buy';} else { echo 'add_payment_info';} ?>"
                                       class="btn btn-green btn-success btn-lg "><?php echo $user->getRomanticReport() ? "View Now" : 'Access' ?></a>
                                </li>
                            </ul>
                        </div>
            <div class="my-cosmos-headline"></div>
                    </div>

                    <!--    <a class="btn btn-lg btn-block btn-warning btn-yellow btn-chat" href="">Chat with a Specialist >></a>
                   TODO: use this image for non auth users
                     <img src="/images/unlock-cosmos.png" alt="" class="img-responsive img-wide"/>  -->


    <script>
        $('#getting-started').countdown("{{$timer->count_down_date}}", function(event) {
            var totalHours = event.offset.totalDays * 24 + event.offset.hours;
            $(this).html(event.strftime(totalHours + ':%M:%S'));
        });
    </script>
@endsection