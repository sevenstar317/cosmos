<div class="clearfix chat-specialists-wrapper">
    <div class="select-specialist">


            <div   ng-show="(vm.rooms | filter:agentOnline).length == 0" style="border: 3px solid #0972b4;padding: 5px;margin:10px;text-align: center;">
                <div style="    font-size: 17px;    color: #184764;    font-family: Lato-Bold, sans-serif;    margin-top: 10px;    margin-bottom: 0;  padding: 0 30px;">
                    Connecting to Advisors
                </div>

                <img src="/images/Secure-Connection_animation.gif" alt=""/>

                <div style=" font-size: 17px;    color: #184764;    font-family: Lato, sans-serif;    margin-top: 10px;    margin-bottom: 0;  padding: 0 30px;">Please be patient... This may take a Moment!</div>
            </div>

            <div class="col col-sm-4" ng-repeat="room in vm.rooms | filter:agentOnline">
                <a     <?php  if(isset(Auth::user()->paymentInfo)){ echo '';} else { echo Auth::user()->minutes_balance !== '00:00:00'? '':'id="add_payment_info"';} ?>
                       <?php echo (Auth::user()->minutes_balance !== '00:00:00' && Auth::user()->minutes_balance[0] !== '-')? 'ui-sref="customers({room: room.id, agent_id: room.agent_id, client_id: room.user_id})"':'id="add_funds"'?>
                   class="advisor-container clearfix">
                    <div class="advisor-image-outer">
                        <div class="advisor-image">
                            <img ng-src="/uploads/<%room.agent.image%>" alt="" class="img-responsive img-wide">
                        </div>
                    </div>
                    <div class="advisor-name" ng-bind="(room.agent.name)"></div>
                    <div class="advisor-spec">

                        <div class="row">
                            <div class="col col-xs-5">
                                Speciality:
                            </div>
                            <div class="col col-xs-7">
                                <ul class="list-unstyled">
                                    <li > <% room.agent.speciality_1 %><img ng-src="/images/horoscope-<% room.agent.speciality_1  | lowercase %>-blue.png" alt=""/></li>
                                    <li > <% room.agent.speciality_2 %><img ng-src="/images/horoscope-<% room.agent.speciality_2  | lowercase %>-blue.png" alt=""/></li>
                                    <li > <% room.agent.speciality_3 %><img ng-src="/images/horoscope-<% room.agent.speciality_3  | lowercase %>-blue.png" alt=""/></li>
                                    <li > <% room.agent.speciality_4 %><img ng-src="/images/horoscope-<% room.agent.speciality_4  | lowercase %>-blue.png" alt=""/></li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </a>
            </div>

    </div>
    </div>