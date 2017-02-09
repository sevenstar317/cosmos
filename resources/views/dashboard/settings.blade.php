@extends('layouts.dashboard')

<?php use Collective\Html\FormFacade as Form; ?>

@section('content')
    <div class="clearfix livechat-container">

        @include('layouts._dashboard_left_menu_for_settings')

        <div class="col col-sm-10 livechat-content">
            <div class="tab-content">

                <div role="tabpanel" class="active tab-pane account-settings-tab " id="account-settings">

                    @include('dashboard.partials._settings')

                </div>
            </div>
        </div>
    </div>
@endsection