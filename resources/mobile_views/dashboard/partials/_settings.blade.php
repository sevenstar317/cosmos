<!-- Nav tabs -->
<ul class="nav nav-pills account-settings-menu" role="tablist">
    <li class="active">
        <a href="#my-account-inner" aria-controls="my-account-inner" role="tab" data-toggle="tab">My Account</a>
    </li>
    <li class="">
        <a href="#billing" aria-controls="billing" role="tab" data-toggle="tab">Billing</a>
    </li>
    <li>
        <a href="#add-funds" aria-controls="add-funds" role="tab" data-toggle="tab">Add Minutes</a>
    </li>
    <li class="">
        <a href="#support" aria-controls="support" role="tab" data-toggle="tab">Support</a>
    </li>
</ul>

<!-- Tab panes -->

<div class="tab-content">
    <div role="tabpanel" class="tab-pane my-account-inner-tab active" id="my-account-inner">
            <div class="inner-pane-padding">
                <div class="my-account-update text-left">
                    {!! Form::model($user, ['route' => ['user.update'],'class'=> 'form-horizontal']) !!}
                    {!! csrf_field() !!}
                    <div class="form-column">
                        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                <input type="text" name="first_name" value="{{ old('first_name')?:$user->first_name }}" class="form-control" placeholder="First Name"/>
                            @if ($errors->has('first_name'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                <input type="text" name="last_name" value="{{ old('last_name')?:$user->last_name }}" class="form-control" placeholder="Last Name"/>
                            @if ($errors->has('last_name'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                                <input type="text" name="name" value="{{ old('name')?:$user->name }}" class="form-control" placeholder="User Name"/>

                            @if ($errors->has('name'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                               <input type="email" name="email" value="{{ old('email')?:$user->email }}" class="form-control" placeholder="Email"/>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">

                                <input type="text" name="phone_number" value="{{ old('phone_number')?:$user->phone_number }}" class="form-control" placeholder="Phone Number"/>
                            </div>
                            @if ($errors->has('phone_number'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('phone_number') }}</strong>
                                </span>
                            @endif

                        <div class="form-group{{ $errors->has('address_1') ? ' has-error' : '' }}">

                                <input type="text" name="address_1" value="{{ old('address_1')?:$user->address_1 }}" class="form-control" placeholder="Address"/>

                            @if ($errors->has('address_1'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('address_1') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">

                                <input autocomplete="off" type="text" placeholder="State" data-provide="typeahead" value="{{old('state')?:$user->state}}" class="form-control " name="state" id="state" />


                            @if ($errors->has('state'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('state') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">

                                <input autocomplete="off" type="text" placeholder="City" data-provide="typeahead" value="{{old('city')?:$user->city}}" class="form-control" name="city" id="city" />


                            @if ($errors->has('city'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('city') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('zip') ? ' has-error' : '' }}">

                                <input type="text" name="zip" value="{{ old('zip')?:$user->zip }}" class="form-control" placeholder="ZIP code"/>

                            @if ($errors->has('zip'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('zip') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="clearfix text-center">
                                <button type="submit" class="btn btn-lg btn-success btn-green btn-edit">Update Profile</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="inner-pane-padding">
                <div class="my-account-update text-left">
                    {!! Form::model($user, ['route' => 'user.change-password','class'=> 'form-horizontal']) !!}
                    {!! csrf_field() !!}
                    <div class="form-column">
                        <h4>Update your password</h4>
                        <div class="form-group">
                                <input type="password" class="form-control" name="old_password" id="old_password">
                            @if ($errors->has('old_password'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('old_password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                                <input type="password" class="form-control" name="new_password" id="new_password">
                            @if ($errors->has('new_password'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('new_password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                                <input type="password" class="form-control" name="new_password_confirmation" id="new_password_confirmation">
                            </div>
                            @if ($errors->has('new_password_confirmation'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('new_password_confirmation') }}</strong>
                                </span>
                            @endif
                        <div class="clearfix text-center">
                            <button type="submit" class="btn btn-lg btn-primary btn-blue btn-update-password">Save Changes</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>

    </div>
    <div role="tabpanel" class="tab-pane billing-tab" id="billing">
        <div class="inner-pane-padding">
            <div class="my-account-billing">
                <div class="billing-owner">
                    <h4>Billing Owner</h4>
                    <p>{{$user->getFullName()}} (Billing owner)</p>
                    <div>
                        <a class="email" href="mailto:{{$user->email}}">{{$user->email}}</a>
                    </div>
                </div>

                <div class="billing-information" id="payment_info_view">
                    <h4>Billing Information</h4>
                    <?php if($user->paymentInfo): ?>
                    <p><?php echo substr( $user->paymentInfo->card_number, 0, 1 ) == '4' ? 'Visa' : 'Mastercard'  ?> ****{{substr($user->paymentInfo->card_number,-4)}}<br>Expires  {{$user->paymentInfo->card_month}}/{{$user->paymentInfo->card_year}}<br>{{$user->paymentInfo->card_name}}<br>{{$user->paymentInfo->zip}}</p>
                    <?php endif; ?>
                    <a href="" class="btn btn-success btn-green" id="payment_info_button">Edit</a>
                </div>
                <div class="row">
                    <div class="col col-sm-12 no-display" id="payment_info_edit" >
                        {!! Form::model($payment, ['route' => 'user.edit-payment','id'=>'payment_edit_form']) !!}
                        {!! Form::hidden('id',$payment && $user->paymentInfo?$payment->id:null) !!}
                        <div class="column column-right checkout-form-wrapper">
                            <h2 class="heading">Your credit card</h2>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}<br>
                                    @endforeach
                                </div>
                            @endif
                            <div class="clearfix">
                                <div class="col col-xs-12">
                                    <div class="form-group">
                                        <label for="name-id">Name on Card</label>
                                        {!! Form::text('card_name', old('card_name'), ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group">
                                        <label for="card-number-id">Card Number</label>
                                        {!! Form::text('card_number', old('card_number'), ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group">
                                        <img src="/images/visa.png" alt=""/>
                                        <img src="/images/mastercard.png" alt=""/>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix">
                                <div class="form-group">
                                    <div class="col col-sm-8 expiration-age">
                                        <label>Expiration Date</label>
                                        {{ Form::select('card_month', ['01'=>'01','02'=>'02','03'=>'03','04'=>'04','05'=>'05','06'=>'06','07'=>'07','08'=>'08','09'=>'09','10'=>'10','11'=>'11','12'=>'12'],old('card_month'),['class'=>'form-control']) }}
                                        {{ Form::select('card_year', ['2016'=>'2016','2017'=>'2017','2018'=>'2018','2019'=>'2019','2020'=>'2020','2021'=>'2021'],old('card_year'),['class'=>'form-control']) }}

                                    </div>
                                    <div class="col col-sm-4">
                                        <div class="form-group">
                                            <label for="cvv-id">CVV Code</label>
                                            {!! Form::text('card_cvv', old('card_cvv'), ['class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix">
                                <div class="col col-xs-6">
                                    <div class="form-group">
                                        <label for="zip-id">Zip/Postal Code</label>
                                        {!! Form::text('zip', old('zip'), ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix">
                                <div class="column checkout-bottom">
                                    <div class="clearfix">
                                        <div class="col col-sm-6">
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-lg btn-success btn-green btn-start">
                                                    Save
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
                <div class="billing-history">
                    <?php
                    foreach($paymentHistory as $history){ if(isset($history->paymentInfo)){?>
                    <table class="table">
                        <tbody>
                        <tr>
                            <td class="key">Description</td>
                            <td class="value">{{$history->description}}</td>
                        </tr>

                        <tr>
                            <td class="key">Name on Card</td>
                            <td class="value">{{$history->paymentInfo->card_name}}</td>
                        </tr>
                        <tr>
                            <td class="key">Last digits</td>
                            <td class="value">{{substr($history->paymentInfo->card_number,-4,4)}}</td>
                        </tr>
                        <tr>
                            <td class="key">Total</td>
                            <td class="value">${{$history->total}}</td>
                        </tr>
                        </tbody>
                    </table>
                    <?php
                 }   }
                    ?>
                </div>
            </div>
        </div>
        <div class="horizontal-separator"></div>

    </div>
    <div role="tabpanel" class="tab-pane " id="add-funds">
        <div class="inner-pane-padding">
            <div class="my-account-add-funds text-center">
                <div class="account-plan">
                    <img src="/images/account-clock.png" alt="">
                    <div class="plan-time"><span>5</span> <small>min</small></div>
                    <div class="plan-price">$29.95</div>
                    <div class="clearfix">
                        <div class="col col-xs-12">
                            <a href="" id="add_5_minutes" class="btn btn-block btn-primary btn-add">Add</a>
                        </div>
                    </div>
                </div>
                <div class="account-plan">
                    <div class="most-popular">Most Popular</div>
                    <img src="/images/account-clock.png" alt="">
                    <div class="plan-time">
                        <span>10</span>
                        <small>min</small>
                        <div class="free">+1 min free</div>
                    </div>
                    <div class="plan-price">$39.95</div>
                    <div class="clearfix">
                        <div class="col col-xs-12">
                            <a href=""  id="add_10_minutes"  class="btn btn-block btn-primary btn-add">Add</a>
                        </div>
                </div>
            </div>
                <div class="account-plan">
                    <img src="/images/account-clock.png" alt="">
                    <div class="plan-time"><span>15</span> <small>min</small></div>
                    <div class="plan-price">$44.25</div>
                    <div class="clearfix">
                        <div class="col col-xs-12">
                            <a href=""  id="add_15_minutes"  class="btn btn-block btn-primary btn-add">Add</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="support">
        <div class="inner-pane-padding">
            <div class="my-account-support text-left">
                <div class="company-address">
                        <h4>Live Cosmos LLC</h4>
                        <p>228 Hamilton Ave.<br>3rd Floor.<br>Palo Alto CA, 94301<br>Toll Free: 1-866-994-5907<br>Customer Service: 24/7<br>Holidays May Vary</p>

                        <img src="/images/map.png" alt="" class="img-responsive">

                </div>
                    {!! Form::open(['route' => ['user.contact-support'], 'id'=>'contact_support']) !!}
                    {!! csrf_field() !!}
                <div class="form-column">
                    <div class="form-group">
                            <input type="text" class="form-control" name="name" id="name" required placeholder="enter your first &amp; last name">

                    </div>
                    <div class="form-group">
                            <input type="email" class="form-control" name="email" id="email" required placeholder="enter your email">
                    </div>
                    <div class="form-group">
                        <label for="">Reason for Contact</label>
                                {{ Form::select('reason', ['Account'=>'Account','Payment'=>'Payment','Other help'=>'Other help'],null,['class'=>'form-control']) }}

                    </div>
                    <div class="form-group">
                            <textarea id="message" class="form-control" name="message" rows="4" required placeholder="type your message..."></textarea>

                    </div>
                    <div class="clearfix text-center">
                            <button type="submit" id="contact_support_button" class="btn btn-success btn-green btn-lgt btn-send">Send</button>
                        </div>
                </div>
                {!! Form::close() !!}


            </div>
        </div>
    </div>
</div>
<br/>
<div class="my-cosmos-headline"></div>