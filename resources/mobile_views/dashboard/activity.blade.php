@extends('layouts.dashboard_mobile')

@section('content')
    <div class="website-content">
        <?php $timer = \App\Models\Timer::find(1); ?>
        <div class="breadcrumbs">
            <ul class="list-unstyled list-inline">
                <li><a href="/dashboard/initial"><i class="fa fa-chevron-left" aria-hidden="true"></i> Account Activity</a></li>
            </ul>
        </div>
                    <form class="form text-center account-activity-form">
                        <div class="form-group">
                            <label for="" >Show activity from</label>

                            <div class="input-group date" id="datetimepicker1">
                                <input  name="from_date" type="text" class="form-control input-lg" value="{{ old('from_date')}}" placeholder="07/02/2016">
                                                <span class="input-group-addon">
                                                    <span class="fa fa-chevron-down"></span>
                                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">to</label>

                            <div class="input-group date" id="datetimepicker2">
                                <input name="to_date" type="text" class="form-control input-lg" value="{{ old('to_date')}}" placeholder="10/02/2016">
                                                <span class="input-group-addon">
                                                    <span class="fa fa-chevron-down"></span>
                                                </span>
                            </div>
                        </div>
                            <div class="form-group">
                                <input type="submit" style="width:100%" value="Update" class="btn btn-blue btn-lg btn-primary">
                            </div>
                    </form>
       <div id="account-activity-generic" class="carousel slide account-activity-carousel" data-ride="carousel">
                <ol class="carousel-indicators">

                    <?php  $i = 0;   foreach ($paymentHistory as $history) { if($i < 10){ ?>
                    <li data-target="#account-activity-generic" data-slide-to="{{$i++}}" class="{{$i === 0 ? 'active' : ''}}"></li>
                    <?php }} ?>

                </ol>

                <div class="carousel-inner" role="listbox">
                    <?php $i = 0;
                    foreach ($paymentHistory as $history) {
                    $desc = $history->report_id ? link_to('reports/view-report/' . $history->report_id, $history->description) : $history->description;
                    ?>
                    <div class="item {{$i === 0 ? 'active' : ''}}">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>Date & Time</th>
                                    <td>{{$history->created_at}}</td>
                                </tr>
                                <tr>
                                    <th>Type</th>
                                    <td>{{$desc}}</td>
                                </tr>
                                <tr>
                                    <th>Amount</th>
                                    <td>${{$history->total}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <?php $i++;}  ?>
                </div>

                <a class="left carousel-control" href="#account-activity-generic" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#account-activity-generic" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>

                    <div class="account-activity-balance-info text-center">
                        <div class=" balance-wrapper">
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