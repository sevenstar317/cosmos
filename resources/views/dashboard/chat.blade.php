@extends('layouts.dashboard_chat')

@section('content')
    <div class="clearfix livechat-container">

        @include('layouts._dashboard_left_menu_for_chat')

        <div class="col col-sm-10 livechat-content">
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane live-chat-tab active" id="live-chat">
                    <div class="inner-pane-padding">
                        <div class="page-loading2">Loading...</div>
                        <div class="livechat-wrapper">
                            <div class="page-loading">Loading...</div>
                            <section ui-view id="ui-view"></section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection