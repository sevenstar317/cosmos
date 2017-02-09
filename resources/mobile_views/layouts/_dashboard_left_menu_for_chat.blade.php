<div class="col col-sm-2 sidebar-menu">
    <ul class="list-unstyled">
        <li class=" my-cosmos-control">
            <a href="<?php echo !isset(Auth::user()->paymentInfo)?'':'/dashboard/my-cosmos'?>" >
                <img src="/images/livechat-tab-1.png" alt=""/>
                <span>My Cosmos</span>
            </a>
        </li>
        <li class="active live-chat-control">
            <a href="/dashboard/live-chat/{{Auth::user()->id}}">
                <img src="/images/livechat-tab-2.png" alt=""/>
                <span>Live Chat</span>
            </a>
        </li>
        <li>
            <a href="/dashboard/activity" >
                <img src="/images/livechat-tab-4.png" alt=""/>
                <span>Account Activity</span>
            </a>
        </li>
        <li >
            <a href="/dashboard/settings" a>
                <img src="/images/livechat-tab-6.png" alt=""/>
                <span>Account Settings</span>
            </a>
        </li>
        <li>
            <div>
                <img src="/images/toll-free.png" alt=""/>
                <span>Customer Service<br/>1-866-994-5907</span>
            </div>
        </li>
    </ul>
</div>