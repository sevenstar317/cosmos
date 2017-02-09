<div class="col col-sm-3 text-center">
	<div class="content-block chat-details">
		<h3 class="title">time on chat:</h3>
		<div class="chat-time"><timer start-time="vm.room.started_chat_on" autostart="false" interval="1000"><% hhours %>:<%mminutes%>:<%sseconds%></timer></div>
		<div class="details clearfix">
			<h4 class="subtitle">details:</h4>
			<ul class="list-unstyled">
				<li class="clearfix">
					<span class="text-right">first name</span>
					<span class="text-left" ng-bind="vm.agent.customer.first_name"></span>
				</li>
				<li class="clearfix">
					<span class="text-right">last name</span>
					<span class="text-left" ng-bind="vm.agent.customer.last_name"></span>
				</li>
				<li class="clearfix">
					<span class="text-right">horoscope sign</span>
					<span class="text-left" ng-bind="vm.agent.customer.sign"></span>
				</li>
				<li class="clearfix">
					<span class="text-right">date of birth</span>
					<span class="text-left" ng-bind="(vm.agent.customer.birth_month) + ', '+ (vm.agent.customer.birth_day) + ' ' + (vm.agent.customer.birth_year)"></span>
				</li>
				<li class="clearfix">
					<span class="text-right">gender</span>
					<span class="text-left" ng-bind="vm.agent.customer.sex"></span>
				</li>
				<li class="clearfix">
					<span class="text-right">time of birth</span>
					<span class="text-left" ng-bind="vm.agent.customer.birth_time"></span>
				</li>
				<li class="clearfix">
					<span class="text-right">state</span>
					<span class="text-left" id="state" ng-bind="vm.agent.customer.state"></span>
				</li>
				<li class="clearfix">
					<span class="text-right">city</span>
					<span class="text-left" id="city" ng-bind="vm.agent.customer.city"></span>
				</li>
				<li class="clearfix">
					<span class="text-right">package</span>
					<span class="text-left" ng-bind="vm.agent.customer.package"></span>
				</li>
				<span class="text-left" style="visibility: hidden" ng-bind="vm.agent.customer.ip"></span>
				<span class="text-left" style="visibility: hidden" id="lat" ng-bind="vm.agent.customer.lat"></span>
				<span class="text-left" style="visibility: hidden" id="lan" ng-bind="vm.agent.customer.lan"></span>
			</ul>
		</div>
		<div class="location">
			<h4 class="subtitle">location:</h4>
			<div id="map" class="img-responsive"></div>
		</div>
		<h3 class="title">time on chat:</h3>
		<div class="chat-time"><timer start-time="vm.room.started_chat_on" autostart="false" interval="1000"><% hhours %>:<%mminutes%>:<%sseconds%></timer></div>
	</div>
	<div class="content-block">
		<h3 class="title">Horoscope info</h3>
		<!--
		<div>
			<button data-toggle="modal" data-target="#myModal"  class="btn btn-primary" ng-bind="(vm.agent.customer.sign) + ' info'"></button>
		</div>
		<br/>
		!-->
		<div class="content-block">
			<button id="hidden-logout" style="visibility: hidden;" ng-click="logoutAgent()"></button>
			<div style="padding: 5px;">
				<button onclick="window.open('https://connect.livecosmos.com/chat-advisor/info','_blank')"  class="btn btn-primary" >Astrology Info Center</button>
			</div>
			<div style="padding: 5px;">
				<button onclick="window.open('https://connect.livecosmos.com/chat-advisor/info2','_blank')"  class="btn btn-primary" >Software Direction</button>
			</div>
			<div style="padding: 5px;">
				<button onclick="window.open('https://connect.livecosmos.com/chat-advisor/info3','_blank')"  class="btn btn-primary" >Opening Script</button>
			</div>

			<div style="padding: 5px;">
				<button onclick="window.open('https://connect.livecosmos.com/chat-advisor/info4','_blank')"  class="btn btn-primary" >Elements & Signs</button>
			</div>

			<div style="padding: 5px;">
				<button onclick="window.open('https://connect.livecosmos.com/chat-advisor/info5','_blank')"  class="btn btn-primary" >Houses Description</button>
			</div>

			<div style="padding: 5px;">
				<button ng-click="popupWindow1(vm.agent.customer.sign)" class="btn btn-primary" >Sign Info Center</button>
			</div>

			<div style="padding: 5px;">
				<button ng-click="popupWindow2(vm.agent.customer.sign)"  class="btn btn-primary" >Sign Ruling Planets</button>
			</div>
		</div>

		<br/>
		<!-- Modal -->
		<div class="modal fade" id="myModal" role="dialog" >
			<div class="modal-dialog" style="width:800px;">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Horoscope info</h4>
					</div>
					<div class="modal-body">
						<p>
							@include('agent.partials._horoscope_info')
						</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>

			</div>
		</div>

	</div>
</div>

<div class="col col-sm-6 content-block center-block">
	<div class="chat-body">
		<!-- Nav tabs -->
		<ul class="nav nav-tabs nav-justified" role="tablist">

			<li role="presentation"  ng-class="room.id == vm.room.id ? 'active' : '' "  ng-repeat="room in pagedItems[currentPage] | filter:chatActiveOrCompleted">
				<a  ui-sref="agents({room: room.id, agent_id: room.agent_id, client_id: room.user_id})" >
					<div class="adv-name" ng-bind="room.client.name"></div>

					<div class="new-messages" ng-bind="room.new_mess_count">0</div>

					<div class="chat-time" >-</div>
				</a>
				<a class="close-chat"  ng-if="'Completed' == room.chat_status"  href="/chat-advisor/end-chat/<% room.agent_id %>/<% room.user_id %>" ><div  >X</div></a>
			</li>

		</ul>

		<div class="clearfix tabs-switcher">
			<div class="col col-xs-1">
				<a href="" class="btn btn-link" data-direction="prev" ng-click="prevPage()">
					<i class="fa fa-chevron-left" aria-hidden="true"></i>
				</a>
			</div>
			<div class="col col-xs-10 text-center switcher-text">
				<span ng-bind="(vm.agent.customer.first_name) + ' '+ (vm.agent.customer.last_name) + ' has joined the chat!'" ></span>
				<span ng-bind="(vm.agent.name) + ' has joined the chat!'" ></span>
				<span style="color:#00AA00;" ng-bind="vm.typing" ></span>
			</div>
			<div class="col col-xs-1">
				<a href="" class="btn btn-link btn-next" data-direction="next" ng-click="nextPage()">
					<i class="fa fa-chevron-right" aria-hidden="true"></i>
				</a>
			</div>
		</div>

		<!-- Tab panes  active in -->
		<div class="tab-content">

			<div role="tabpanel" class="tab-pane fade in active" id="chat-0">
				<div class="messages-container"  ng-scroll-bottom messages="vm.messages" typing="vm.typing" >

					<div class="clearfix message" ng-repeat="message in vm.messages">
						<div ng-bind="message.when | date : 'fullDate'" class="timestamp"></div>
						<div class="col col-xs-2 text-center pad-zero-left">
							<img src="/images/agent-blank.png" ng-if="'agent' == message.sender_type" alt=""/>
							<img src="/images/member-blank.png" ng-if="'agent' != message.sender_type" alt=""/>
							<span class="name" ng-bind="vm.agent.name"   ng-if="'agent' == message.sender_type"  ></span>
							<span class="name" ng-bind="(vm.agent.customer.first_name) + ' '+ (vm.agent.customer.last_name)"   ng-if="'agent' != message.sender_type" ></span>
						</div>
						<div class="col col-xs-10 pad-zero-left">
							<div ng-bind-html="message.message | emoji" ng-if="'agent' == message.sender_type" class="message-text"></div>
							<div ng-bind-html="message.message | emoji" ng-if="'agent' != message.sender_type" class="message-text"  style="color:#0000ed;"></div>
						</div>
					</div>
				</div>

				<div style="height:30px;width: 100%;text-align: center;">
					<span style="color:#00AA00;" ng-bind="vm.typing" ></span>
				</div>

				<form ng-if="vm.agentConnected" ng-submit="vm.sendMessage()">
					<div class="form-group">
						<div class="input-group">
							<input ng-model="vm.message"  ng-keypress="typingAgent()" id="em_text" onfocus="
							if(typeof $('.emoji-wysiwyg-editor').val() === 'undefined'){
								$('#em_text').emojiarea({button: '#emojiable-option'});
							}
					 		" class="form-control input-lg" type="text">
                               <span class="input-group-btn">
                                 <button class="btn btn-default" type="submit"><img src="/images/send-icon.png" alt="Send"></button>
                                 <button class="btn btn-default" id="emojiable-option"  onfocus="
                                 if(typeof $('.emoji-wysiwyg-editor').val() === 'undefined'){
									$('#em_text').emojiarea({button: '#emojiable-option'});
								 }"  type="button"><img src="/images/emoticon-icon.png" alt="Smile"></button>
                               </span>
						</div>
					</div>
				</form>
			</div>

		</div>
	</div>
</div>
<div class="col col-sm-3 text-center">
	<div class="content-block">
		<h3 class="title">pending chats</h3>


		<ul class="list-unstyled pending-chats">
			<span ng-show="(vm.rooms | filter:{chat_status:'Pending'}).length == 0">No pending chats</span>
			<li class="row" style="margin-left: 0px;  margin-right: 0px;" ng-repeat="room in vm.rooms | filter:{chat_status:'Pending'} | orderBy:'':true">
				<div class="col col-sm-7">
					<span ng-bind="room.client.name" style="display: inline-block;margin-top: 5px;"> </span>
				</div>
				<div class="col col-sm-5">
					<a ui-sref="agents({room: room.id, agent_id: room.agent_id, client_id: room.user_id})">Accept User</a>
				</div>
			</li>

		</ul>
	</div>

</div>

<script type="text/javascript">
	setTimeout(function() {

		var latlng = new google.maps.LatLng($('#lat').text(), $('#lan').text());console.log(latlng);
		var myOptions = {
			zoom: 5,
			center: latlng,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		var map = new google.maps.Map(document.getElementById("map"),
				myOptions);

		var marker = new google.maps.Marker({
			position: latlng,
			map: map,
			title: 'User\'s Location'
		});
	},1400);


</script>