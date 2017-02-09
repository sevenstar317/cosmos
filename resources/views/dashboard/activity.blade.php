@extends('layouts.dashboard')

@section('content')
    <div class="clearfix livechat-container">

        @include('layouts._dashboard_left_menu_for_activity')

        <div class="col col-sm-10 livechat-content">
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane account-activity-tab active" id="account-activity">
                    <form method="POST" class="form-inline">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <label for="" class="pull-left">Show activity from</label>

                            <div class="input-group date" id="datetimepicker1">
                                <input name="from_date" type="text" class="form-control input-lg" value="{{ old('from_date')}}" placeholder="07/02/2016">
                                                <span class="input-group-addon">
                                                    <span class="fa fa-chevron-down"></span>
                                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="pull-left">to</label>

                            <div class="input-group date" id="datetimepicker2">
                                <input name="to_date" type="text" class="form-control input-lg" value="{{ old('to_date')}}" placeholder="10/02/2016">
                                                <span class="input-group-addon">
                                                    <span class="fa fa-chevron-down"></span>
                                                </span>
                            </div>
                        </div>
                        <div class="clearfix text-center">
                            <div class="form-group">
                                <input type="submit" value="Update" class="btn btn-blue btn-lg btn-primary">
                            </div>
                        </div>
                    </form>
                    <table class="table">
                        <thead>
                        <tr>
                            <td>Type</td>
                            <td>Date</td>
                            <td>Card Name</td>
                            <td>Last 4 digits</td>
                            <td>Amount</td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($paymentHistory as $history) {
                            $desc = $history->report_id ? link_to('reports/view-report/'.$history->report_id, $history->description) : $history->description;
                            echo '<tr><td>'.$desc. '</td><td>'.$history->created_at.'</td><td>'. $history->paymentInfo->card_name .'</td><td>'. substr($history->paymentInfo->card_number, -4, 4) .'</td><td>'. $history->total .'</td></tr>';
                        }
                        ?>
                        <tr>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                        </tbody>
                    </table>

                    <div class="clearfix balance-info text-center">
                        <div class="col col-sm-offset-1 col-sm-4 balance-wrapper">
                            <h3>Minutes Balance</h3>

                            <h1 class="balance">{{$user->minutes_balance}}</h1>

                            <div class="pad">
                                <a href="" id="add_funds" class="btn btn-lg btn-success btn-green btn-block">Add
                                    Minutes</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection