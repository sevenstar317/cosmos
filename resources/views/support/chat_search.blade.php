@extends('layouts.support')

@section('content')
    <div class="container">

        <div class="row">
            <?php if(isset($user)): ?>
            <div class="col-md-6 ">
                <div class="panel panel-default panel-primary">
                    <div class="panel-heading">User info</div>
                    <div class="panel-body">
                        <div class="content-block chat-details">
                            <div class="details clearfix">
                                <ul class="list-unstyled">
                                    <li class="clearfix">
                                        <span class="text-right">Name</span>
                                        <span class="text-left">{{$user->first_name}} {{$user->last_name}}</span>
                                    </li>
                                    <li class="clearfix">
                                        <span class="text-right">horoscope sign</span>
                                        <span class="text-left">{{$user->sign}}</span>
                                    </li>
                                    <li class="clearfix">
                                        <span class="text-right">state</span>
                                        <span class="text-left">{{$user->state}}</span>
                                    </li>
                                    <li class="clearfix">
                                        <span class="text-right">city</span>
                                        <span class="text-left">{{$user->city}}</span>
                                    </li>
                                    <li class="clearfix">
                                        <span class="text-right">ip</span>
                                        <span class="text-left">{{$user->ip}}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <?php endif; ?>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">Chat search by email</div>

                    <div class="panel-body">
                        <form method="POST" action="{{ url('/customer-support/chat-search') }}">
                            {!! csrf_field() !!}

                            <h4>
                                Please input email of user
                            </h4>

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <input type="text" name="email" value="" autocomplete="off" id="435435"
                                       class="form-control input-lg" placeholder="Email"/>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-success btn-block btn-lg btn-green">Search</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php if(isset($chats)): ?>
        <div class="row">
            <div class="col-md-12 ">
                <div class="panel panel-default">
                    <div class="panel-heading">Result (Select Agent)</div>

                    <div class="panel-body">

                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

                            <?php foreach($chats as $key => $chat):  ?>
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="heading{{$key}}">
                                            <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$key}}" aria-expanded="true" aria-controls="collapse{{$key}}">
                                                    Agent: <i>{{$chat['room']['agent']}}</i>  &nbsp; Date: <i>{{$chat['room']['date']}}</i>   &nbsp; Duration: <i>{{$chat['room']['length']}}</i>
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapse{{$key}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{$key}}">
                                            <div class="panel-body">
                                                <div class="messages-container"
                                                     style="    height: 500px;   overflow-y: scroll;   overflow-x: hidden;">

                                                    <?php foreach($chat['messages'] as $message): ?>
                                                    <div class="clearfix message"
                                                         style="margin: 5px;padding: 5px;border-bottom: 1px blue solid;">
                                                        <div class="timestamp">{{$message['created_at']}}</div>

                                                        <div class="col col-xs-3 text-center pad-zero-left">
                                                            @if($message['sender_type'] == 'agent')
                                                                <img src="/images/agent-blank.png"/><br/>
                                                                <span class="name">{{$chat['room']['agent']}}</span>
                                                            @else
                                                                <img src="/images/member-blank.png"/><br/>
                                                                <span class="name">{{$chat['room']['client']}}</span>
                                                            @endif
                                                        </div>

                                                        <div class="col col-xs-9 pad-zero-left">
                                                            @if($message['sender_type'] == 'agent')
                                                                <div class="message-text">{{$message['message']}}</div>
                                                            @else
                                                                <div class="message-text"
                                                                     style="color:#0000ed;">{{$message['message']}}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <?php endforeach ?>

                                                </div>

                                              </div>
                                        </div>
                                    </div>
                             <?php endforeach ?>

                        </div>





                        </div>
                    </div>
                </div>

            </div>

        <?php endif; ?>
    </div>
@endsection
