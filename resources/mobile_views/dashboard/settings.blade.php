@extends('layouts.dashboard_mobile')

@section('content')
    <div class="website-content">
        <div class="breadcrumbs">
            <ul class="list-unstyled list-inline">
                <li><a href="/dashboard/initial"><i class="fa fa-chevron-left" aria-hidden="true"></i> My Cosmos</a></li>
            </ul>
        </div>

                <div role="tabpanel" class="active tab-pane account-settings-tab " id="account-settings">

                    @include('dashboard.partials._settings')

                </div>
            </div>
@endsection