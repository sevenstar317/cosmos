
    <div class="toll-free text-center">
        <img src="/images/toll-free.png" alt=""/>
        <span>Customer Service 1-866-994-5907</span>
    </div>

    <ul class="list-unstyled user-dash-menu clearfix text-center">
        <li class="col col-xs-12 my-cosmos-control">
            <a style="border-right:0"
               id="<?php  if(isset(Auth::user()->paymentInfo)){ echo '';} else { echo 'add_payment_info';} ?>"
               href="<?php  if(isset(Auth::user()->paymentInfo)){ echo '/dashboard/my-cosmos';} else { echo '';} ?>">
                <img src="/images/my-cosmos.png" alt=""/>
                <span>My Cosmos</span>
            </a>
        </li>
        <li class="col col-xs-12 live-chat-control">
            <a href="/dashboard/live-chat/{{Auth::user()->id}}">
                <img src="/images/live-chat.png" alt=""/>
                <span>Live Chat</span>
            </a>
        </li>
        <li class="col col-xs-6">
            <a  id="<?php  if(isset(Auth::user()->paymentInfo)){ echo '';} else { echo 'add_payment_info';} ?>"
                 href="<?php  if(isset(Auth::user()->paymentInfo)){ echo '/dashboard/activity';} else { echo '';} ?>">
                <img src="/images/account-activity.png" alt=""/>
                <span>Account Activity</span>
            </a>
        </li>
        <li class="col col-xs-6">
            <a  id="<?php  if(isset(Auth::user()->paymentInfo)){ echo '';} else { echo 'add_payment_info';} ?>"
                href="<?php  if(isset(Auth::user()->paymentInfo)){ echo '/dashboard/settings';} else { echo '';} ?>">
                <img src="/images/account-settings.png" alt=""/>
                <span>Account Settings</span>
            </a>
        </li>
    </ul>