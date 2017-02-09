<div class="livechat-wrapper">
<div  click-off="vm.ClickFunction()"></div>
    
	<div class="row">
		<div class="col col-sm-8">
			<div class="chat-container">
				<div class="messages-container" ng-scroll-bottom messages="vm.messages" typing="vm.typing" >
					<div class="clearfix" ng-repeat="message in vm.messages ">
						<div ng-class="message.sender_type !='agent' ? 'message advisor-message pull-right' : 'message member-message pull-left' "  ng-bind-html="message.message | emoji"></div>
					</div>
					<div class="clearfix"  ng-if="vm.typing">
						<div class="message member-message pull-left typing"></div>
					</div>
				</div>

				<form ng-if="vm.customerConnected" ng-submit="vm.sendMessage()" class="form-horizontal">
					<div class="form-group">
						<div class="col col-sm-9 no-padding-right">
							<input type="text" ng-model="vm.message" autocomplete="off" id="{{uniqid("inputext")}}"  ng-keypress="typingUser()" class="form-control input-lg" placeholder="type your message here...">
						</div>
						<div class="col col-sm-3">
							<button type="submit" class="btn btn-green btn-lg btn-success btn-block">Send</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="col col-sm-4">
			<div class="advisor-container text-center">
				<img src="/images/logo.png" alt="" class="img-responsive">
				<div class="advisor-image">
					<img ng-src="/uploads/<%vm.customer.agent.image%>" alt="" class="img-responsive img-wide" style="max-height: 200px;">
				</div>
				<div class="advisor-name" ng-bind="(vm.customer.agent.name)"></div>
				<div class="row controls">
					<div class="col col-xs-6">
						<a href="" id="<?php  if(isset(Auth::user()->paymentInfo)){ echo 'add_funds2';} else { echo 'add_payment_info';} ?>">
							<img src="/images/add-funds.png"
								onclick="
								<?php  if(isset(Auth::user()->paymentInfo)){ echo "event.preventDefault();
									var that = this;
									$('#add-funds-modal-id').modal();
									$('#end-chat-modal-id #end_yes').click(function(){
									window.location.assign( $(that).attr('href'));
								});";} else { echo "";} ?>
								" class="img-responsive">
							<span>Add Minutes</span>
						</a>
					</div>
					<div class="col col-xs-6">
						<a href="/dashboard/end-chat/<% vm.customer.agent.id %>/<% vm.customer.id %>" onclick="
								event.preventDefault();
								var that = this;
								$('#end-chat-modal-id').modal();"
						   id="end_chat" style="cursor:pointer;">
							<img src="/images/end-chat.png" alt="" class="img-responsive">
							<span>End Chat</span>
						</a>
					</div>
				</div>
				<div class="time" > <timer id="tim" start-time="vm.currentRoom.started_chat_on" autostart="false" interval="1000"><% hhours %>:<%mminutes%>:<%sseconds%></timer> </div>
				<!--	<div class="time" ng-bind="vm.currentRoom.started_chat_on">  </div>

                !-->
				<div class="package-type-wrapper">
					<div class="clearfix">
						<div class="col col-xs-6">Package Type</div>
						<div class="col col-xs-6 package-type"><?php
							$pH = Auth::user()->paymentHistory->where('type','minutes')->last();
								if($pH){
									$ex = explode(' ',$pH->description);
									if(isset($ex[0])){
										echo $ex[0];
									} else {
										echo 0;
									}
								}else{
									echo 0;
								} ?> Minutes</div>
					</div>
				</div>
				<div class="row controls">
					<div class="col col-xs-12">
						<a href=""  id="<?php  if(isset(Auth::user()->paymentInfo)){ echo 'email_chat';} else { echo 'add_payment_info';} ?>"  ng-attr-data-id="<%vm.currentRoom.id%>" onclick="">
							<img src="/images/email-chat.png" alt="" class="img-responsive">
							<span>Email Chat</span>
						</a>
					</div>
					<!--	<div class="col col-xs-6">
                            <a href="" id="download_chat" onclick="$('#download-chat-modal-id').modal();">
                                <img src="/images/download-chat.png" alt="" class="img-responsive">
                                <span>Download Chat</span>
                            </a>
                        </div>-->
				</div>
			</div>
			<!-- <a href="" id="monitor_map"  onclick="$('#monitor-chat-modal-id').modal();" class="text-center monitor-cosmos-map">
				<i class="fa fa-angle-double-right left"></i>
				Monitor Your<br> Cosmos Map
				<i class="fa fa-angle-double-right right"></i>
			</a>-->
		</div>
	</div>
</div>



<!-- Modal end chat -->
<div class="modal fade" id="end-chat-modal-id" tabindex="-1" role="dialog" aria-labelledby="end-chat-modal-label">
	<div class="modal-dialog" role="document">
		<div class="modal-content text-center">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">End Chat</h4>
			</div>
			<div class="modal-body">
				<div class="headline"><span>Are you sure</span> you want to exit this chat?</div>
				<div class="row">
					<div class="col col-xs-5">
						<a href="" class="btn btn-default btn-lg btn-block btn-grey ng-scope" ng-click="handleClick()" id="end_yes">Yes, I am sure</a>
					</div>
					<div class="col col-xs-7">
						<a href="" class="btn btn-primary btn-lg btn-block btn-blue"  data-dismiss="modal" id="end_no">No, take me back to chat</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/ng-template" id="modal.html">
	<div class="modal" id="conn_mod"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel"	aria-hidden="true"	 data-backdrop="static"  data-keyboard="false" >
		<div class="modal-dialog" role="document">
			<div class="modal-content text-center">
				<div class="modal-header">
					<button type="button" class="close" ng-click="close(false)" id="close_waiting" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title">Secure Connection</h4>
				</div>
				<div class="modal-body">
					<div class="headline">Making a Secure Connection to <%futurama.name%></div>
					<img src="/images/Secure-Connection_animation.gif" alt=""/>
					<div class="headline headline-normal">Please be patient... This may take a Moment!</div>
				</div>
			</div>
		</div>
	</div>
</script>


<!-- add 5 mins and payment info !-->
<script type="text/ng-template" id="OneMinuteLeftModalCheckout.html">
	<div class="modal fade" id="add-minutes-checkout-modal-id" tabindex="-1" role="dialog" aria-labelledby="personal-map-modal-label">
		<div class="modal-dialog" style="width: 550px" role="document">
			<div class="modal-content text-center">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title">Time Almost Up. Load Minutes Now!</h4>
				</div>
				<div class="modal-body" style="padding-bottom: 0px;">
					<img src="/images/add-minutes-checkout-pop.png" alt=""/>
					<div class="headline">50% OFF 5 Minute Package Now. Only $2.95!<br/> You Can Always Use Your Minutes!</div>
					<div class="row checkout-top checkout-section" style="padding-bottom: 0px;">
						<div class="col col-sm-12 ">
							<div class="column" style="    background-color: rgba(159, 195, 224, 0.8);">
								<h1 class="heading"><span>Limited Time Offer</span> {{date('m/d/Y')}}: Save 50% Now!</h1>
								<div class="clearfix checkout-radios-wrapper">
									<div class="radio radio-1 radio-single active">
										<label class="clearfix">
											<div class="headline-wrapper">
												<input type="radio" checked="">
												<h3 class="headline" style="color:white;font-size: 20px;">5 Minutes</h3>
											</div>
											<div class="clearfix current-price-wrapper">
												<p class="current-price" style="    font-size: 28px;    margin-left: 40%;">$2.95</p>
											</div>
										</label>
									</div>
								</div>
							</div>

						</div>
					</div>
					<form action="/tets" method="POST" id="5_minutes_checkout" class="text-left" style="padding: 10px 0 0;">
						{!! Form::hidden('sku','521634') !!}
						<div class="clearfix">
							<div class="col col-sm-5 ">
								<div class="form-group">
									<label for="">Name on Card</label>
									{!! Form::text('card_name',  $user->first_name .' '. $user->last_name , ['class' => 'form-control','required'=>'required']) !!}
								</div>
							</div>
							<div class="col col-sm-2 ">
								<div class="form-group">
									<label for="">Exp. Date</label>
									{{ Form::select('card_month', ['01'=>'01','02'=>'02','03'=>'03','04'=>'04','05'=>'05','06'=>'06','07'=>'07','08'=>'08','09'=>'09','10'=>'10','11'=>'11','12'=>'12'],null,['class'=>'form-control','required'=>'required']) }}
								</div>
							</div>
							<div class="col col-sm-3">
								<div class="form-group">
									<label for="">&nbsp;</label>
									{{ Form::select('card_year', ['2016'=>'2016','2017'=>'2017','2018'=>'2018','2019'=>'2019','2020'=>'2020','2021'=>'2021'],null,['class'=>'form-control','required'=>'required']) }}
								</div>
							</div>
							<div class="col col-sm-2 no-padding-left">
								<div class="form-group">
									<label for="">CVV Code</label>
									{!! Form::text('card_cvv', '', ['class' => 'form-control','required'=>'required']) !!}
								</div>
							</div>
						</div>

						<div class="clearfix">
							<div class="col col-sm-5">
								<div class="form-group">
									<label for="">Card Number</label>
									{!! Form::text('card_number', '', ['class' => 'form-control', 'style'=>"color:black;border: 1px solid red;background-color: #f2dede",'required'=>'required']) !!}
								</div>
							</div>
							<div class="col col-sm-3">
								<div class="form-group">
									<label for="">Zip/Postal Code</label>
									{!! Form::text('zip', '', ['class' => 'form-control','required'=>'required']) !!}
								</div>
							</div>
						</div>

						<div class="clearfix">
							<div class="col col-xs-12">
								<img src="/images/visa.png" alt=""/>
								<img src="/images/mastercard.png" alt=""/>
							</div>
						</div>

						<div class="modal-footer">
							<button type="submit" id="add_5_minutes_checkout" class="btn btn-primary btn-green btn-lg">continue</button>
						</div>
					</form>
					<div class="row checkout-top checkout-section" style="padding-bottom: 0px">
						<div class="col col-sm-12 ">
							<div class="column" style="    background-color: rgba(159, 195, 224, 0.8);margin-bottom:0px">
								<div class="info-wrapper">
									<div class="anonymous-search">All Readings Are <span>Confidential</span>! We Will Never Share your Information with Anyone!
									</div>
									<div class="testimonials">
										<div class="item">
											<span class="author-name">Ashley R.</span>
											<span class="author-review">"Live Cosmos is the most reliable and accurate astrology and numerology source online"</span>
											<br/>
											<img src="/images/green-stars.png" alt=""/>
										</div>
										<div class="item">
											<span class="author-name">Brad C.</span>
											<span class="author-review">"I was shocked to see how unaware I was about obstacles that blocked my luck"</span>
											<br/>
											<img src="/images/green-stars.png" alt=""/>
										</div>
									</div>
									<div class="secure-icons text-center">
										<img src="/images/secure-icon-1.png" alt=""/>
										<img src="/images/secure-icon-2.png" alt=""/>
										<img src="/images/secure-icon-3.png" alt=""/>
										<img src="/images/secure-icon-4.png" alt=""/>
									</div>
								</div>

								<div class="satisfaction-guarantee">
									<p class="title">100% Satisfaction Guarantee</p>
									<p>If you ever feel unsatisfied with Live Cosmos, Please give us a call 24 hours a day, 7 days a week! Our representatives are
										always ready to help you with any concerns you may have. 1.866.994.5907</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</script>

<script type="text/ng-template" id="OneMinuteLeftModal.html">
	<div class="modal fade" id="add-minutes-modal-id-1" tabindex="-1" role="dialog"
		 aria-labelledby="add-minutes-modal-label">
		<div class="modal-dialog" role="document">
			<div class="modal-content text-center">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title">Add 5 Minutes at 50% OFF!</h4>
				</div>
				<div class="modal-body" style="border-bottom: 2px solid #b3b3b3;">
					<img src="/images/chat-icon.jpg" alt=""/>
					<div class="headline">Continue Your Conversation for only $14.95! You Can Always Use Your Minutes!</div>

				</div>
				<div class="modal-footer">
					<a id="add_5_minutes_cheap" href="" class="btn btn-primary btn-blue btn-lg">Continue</a>

				</div>
			</div>
		</div>
	</div>
</script>

<script type="text/ng-template" id="30sLeftModal.html">
  /*  <div  click-off="vm.ClickFunction()" class="modal fade" id="warning-modal-id-30" tabindex="-1" role="dialog"
         aria-labelledby="add-minutes-modal-label">
        <div class="modal-dialog" role="document">
            <div class="modal-content text-center">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        <p>Hey! Are you there?</p>
                        <p>I am waiting for you!</p>
                      
                        <div class="text-center">
                               <button class="btn btn-success btn-lg warning-button">Yes</button>
                               <div class="warning-text">This chat will close in 30 seconds!</div>
                        </div>
                </div>
            </div>
        </div>
    </div>*/
</script>

<script type="text/ng-template" id="20SecondsLeftModal.html">
	<div class="modal fade" id="add-minutes-modal-id-20" tabindex="-1" role="dialog" aria-labelledby="add-minutes-modal-label">
		<div class="modal-dialog" role="document">
			<div class="modal-content text-center">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title">Add More Minutes</h4>
				</div>
				<div class="modal-body">
					<p>You are running out of time</p>
					<img src="/images/add-funds-icon.png" alt=""/>
					<div class="clearfix">
						<img class="grid-lines" src="/images/grid-lines.png" alt=""/>
					</div>
					<div class="clearfix text-center selectors">
						<div class="col col-xs-4">
							<a href="" id="add_5_minutes" class="add-selector">
								<span class="value">5</span><span class="unity">min</span>
								<span class="hover">+ ADD</span>
							</a>
						</div>
						<div class="col col-xs-4">
							<a href="" id="add_10_minutes" class="add-selector">
								<span class="value">10</span><span class="unity">min</span>
								<span class="hover">+ ADD</span>
							</a>
						</div>
						<div class="col col-xs-4">
							<a href="" id="add_15_minutes" class="add-selector">
								<span class="value">15</span><span class="unity">min</span>
								<span class="hover">+ ADD</span>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</script>