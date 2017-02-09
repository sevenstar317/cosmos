
<div class="col col-sm-3 text-center">
	<div class="content-block chat-details">
		<h3 class="title">time on chat:</h3>
		<div class="chat-time">Connect to client first</div>
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
					<span class="text-left" ng-bind="vm.agent.customer.state"></span>
				</li>
				<li class="clearfix">
					<span class="text-right">city</span>
					<span class="text-left" ng-bind="vm.agent.customer.city"></span>
				</li>
				<li class="clearfix">
					<span class="text-right">package</span>
					<span class="text-left" ng-bind="vm.agent.customer.package"></span>
				</li>
			</ul>
		</div>
		<div class="location">
			<h4 class="subtitle">location:</h4>
			<img src="/images/location.png" class="img-responsive" alt="">
		</div>
	</div>
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
	</div>
</div>

<div class="col col-sm-6 content-block center-block">
	<div class="chat-body">
		<!-- Nav tabs -->
		<ul class="nav nav-tabs nav-justified" role="tablist">

			<li role="presentation"  ng-class="room.id == vm.room.id ? 'active' : '' "  ng-repeat="room in vm.rooms | filter:chatActiveOrCompleted">
				<a  ui-sref="agents({room: room.id, agent_id: room.agent_id, client_id: room.user_id})" >
					<div class="adv-name" ng-bind="room.user.name"></div>

					<div class="new-messages" ng-bind="room.new_mess_count">0</div>

					<div class="chat-time" >-</div>
				</a>
				<a class="close-chat"  ng-if="'Completed' == room.chat_status"  href="/chat-advisor/end-chat/<% room.agent_id %>/<% room.user_id %>" ><div  >X</div></a>
			</li>

		</ul>

		<!-- Tab panes  active in -->
		<div class="tab-content">

			<div role="tabpanel" style="padding: 20px;text-align: center;font-weight: bold;" class="tab-pane fade in active" id="chat-0">
				Select active chat on top or accept pending on right panel.
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
					<span ng-bind="room.user.name" style="display: inline-block;margin-top: 5px;"> </span>
				</div>
				<div class="col col-sm-5">
					<a ui-sref="agents({room: room.id, agent_id: room.agent_id, client_id: room.user_id})" ui-sref-opts="{reload: true}">Accept User</a>
				</div>
			</li>

		</ul>
	</div>
	<!--
	<div class="content-block">
		<h3 class="title">Other Live Astrologists</h3>
		<ul class="list-unstyled live-astrologists">
			<li class="clearfix"  ng-repeat="other_agent in vm.agent.agents">
				<a onclick="event.preventDefault();">
					<div class="avatar">
						<img src="/images/default-avatar.png" alt="">
					</div>
					<div class="name" ng-bind="other_agent.name"></div>
					<div class="status">
						<span class="online">online</span>
					</div>
				</a>
			</li>
		</ul>
	</div>
	!-->
</div>