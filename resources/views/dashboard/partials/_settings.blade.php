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
            <div class="top">
                <div class="row">
                    {!! Form::model($user, ['route' => ['user.update'],'class'=> 'form-horizontal']) !!}
                    {!! csrf_field() !!}
                    <div class="col col-sm-6">
                        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                            <label for="first_name" class="col col-sm-3 no-padding control-label">First Name</label>
                            <div class="col col-sm-9">
                                <input type="text" name="first_name" value="{{ old('first_name')?:$user->first_name }}" class="form-control" placeholder="First Name"/>
                            </div>
                            @if ($errors->has('first_name'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                            <label for="last_name" class="col col-sm-3 no-padding control-label">Last Name</label>
                            <div class="col col-sm-9">
                                <input type="text" name="last_name" value="{{ old('last_name')?:$user->last_name }}" class="form-control" placeholder="Last Name"/>
                            </div>
                            @if ($errors->has('last_name'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col col-sm-3 no-padding control-label">User Name</label>
                            <div class="col col-sm-9">
                                <input type="text" name="name" value="{{ old('name')?:$user->name }}" class="form-control" placeholder="User Name"/>
                            </div>
                            @if ($errors->has('name'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col col-sm-3 no-padding control-label">Email</label>
                            <div class="col col-sm-9">
                               <input type="email" name="email" value="{{ old('email')?:$user->email }}" class="form-control" placeholder="Email"/>
                            </div>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">
                            <label for="phone_number" class="col col-sm-3 no-padding control-label">Phone Number</label>
                            <div class="col col-sm-9">
                                <input type="text" name="phone_number" value="{{ old('phone_number')?:$user->phone_number }}" class="form-control" placeholder="Phone Number"/>
                            </div>
                            @if ($errors->has('phone_number'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('phone_number') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col col-sm-6">
                        <div class="form-group{{ $errors->has('address_1') ? ' has-error' : '' }}">
                            <label for="address_1" class="col col-sm-3 no-padding control-label">Address</label>
                            <div class="col col-sm-9">
                                <input type="text" name="address_1" value="{{ old('address_1')?:$user->address_1 }}" class="form-control" placeholder="Address"/>
                            </div>
                            @if ($errors->has('address_1'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('address_1') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
                            <label for="state" class="col col-sm-3 no-padding control-label">State</label>
                            <div class="col col-sm-9">
                                <input autocomplete="off" type="text" placeholder="State" data-provide="typeahead" value="{{old('state')?:$user->state}}" class="form-control " name="state" id="state" />

                            </div>
                            @if ($errors->has('state'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('state') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                            <label for="city" class="col col-sm-3 no-padding control-label">City</label>
                            <div class="col col-sm-9">
                                <input autocomplete="off" type="text" placeholder="City" data-provide="typeahead" value="{{old('city')?:$user->city}}" class="form-control" name="city" id="city" />

                            </div>
                            @if ($errors->has('city'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('city') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('zip') ? ' has-error' : '' }}">
                            <label for="zip" class="col col-sm-3 no-padding control-label">ZIP code</label>
                            <div class="col col-sm-9">
                                <input type="text" name="zip" value="{{ old('zip')?:$user->zip }}" class="form-control" placeholder="ZIP code"/>
                            </div>
                            @if ($errors->has('zip'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('zip') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group text-right">
                            <div class="col col-xs-12">
                                <button type="submit" class="btn btn-success btn-green">Update Profile</button>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="bottom">
                <div class="row">
                    {!! Form::model($user, ['route' => 'user.change-password','class'=> 'form-horizontal']) !!}
                    {!! csrf_field() !!}
                    <div class="col col-sm-8">
                        <h4>Update your password</h4>
                        <div class="form-group">
                            <label for="old_password" class="col col-sm-4 no-padding control-label">Current Password</label>
                            <div class="col col-sm-8">
                                <input type="password" class="form-control" name="old_password" id="old_password">
                            </div>
                            @if ($errors->has('old_password'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('old_password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="new_password" class="col col-sm-4 no-padding control-label">New Password</label>
                            <div class="col col-sm-8">
                                <input type="password" class="form-control" name="new_password" id="new_password">
                            </div>
                            @if ($errors->has('new_password'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('new_password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="new_password_confirmation" class="col col-sm-4 no-padding control-label">Retype New Password</label>
                            <div class="col col-sm-8">
                                <input type="password" class="form-control" name="new_password_confirmation" id="new_password_confirmation">
                            </div>
                            @if ($errors->has('new_password_confirmation'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('new_password_confirmation') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col col-sm-offset-4 col-sm-8">
                            <button type="submit" class="btn btn-block btn-primary btn-blue">Save Changes</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>

    </div>
    <div role="tabpanel" class="tab-pane billing-tab" id="billing">
        <div class="top">
            <div class="row">
                <div class="col col-sm-6">
                    <h4>Billing Owner</h4>
                    <p>{{$user->getFullName()}} (Billing owner)</p>
                    <div>
                        <a class="email" href="mailto:{{$user->email}}">{{$user->email}}</a>
                    </div>
                </div>

                <div class="col col-sm-6" id="payment_info_view">
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
                                            <div class="btn-access-wrapper">
                                                <a href="#" class="btn btn-block btn-access-report">Access Your Report Instantly <i class="fa fa-arrow-right"></i></a>
                                            </div>
                                        </div>
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
            </div>
        </div>
        <div class="bottom">
            <div class="row">
                <div class="col col-xs-12">
                    <h4>Billing History</h4>
                    <div class="table-responsive">
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
                            if (isset($user->paymentInfo)) {
                                foreach ($paymentHistory as $history) {
                                    if (isset($history->paymentInfo)) {
                                        echo "<tr><td>$history->description</td><td>$history->created_at</td><td>" . $history->paymentInfo->card_name . "</td><td>" . substr($history->paymentInfo->card_number, -4, 4) . "</td><td>$history->total</td></tr>";

                                    }
                                }
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div role="tabpanel" class="tab-pane add-funds-tab" id="add-funds">
        <div class="row text-center account-plans">
            <div class="col col-sm-4">
                <div class="account-plan">
                    <img src="/images/account-clock.png" alt="">
                    <div class="plan-time"><span>5</span> <small>min</small></div>
                    <div class="plan-price">$29.95</div>
                    <div class="clearfix">
                        <div class="col col-xs-12">
                            <a href="" id="add_5_minutes" class="btn btn-block btn-primary btn-add">Add</a>
                            <p>Add 5 minutes to your account</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col col-sm-4">
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
                            <p>Add 10 minutes to your account</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col col-sm-4">
                <div class="account-plan">
                    <img src="/images/account-clock.png" alt="">
                    <div class="plan-time"><span>15</span> <small>min</small></div>
                    <div class="plan-price">$44.25</div>
                    <div class="clearfix">
                        <div class="col col-xs-12">
                            <a href=""  id="add_15_minutes"  class="btn btn-block btn-primary btn-add">Add</a>
                            <p>Add 15 minutes to your account</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div role="tabpanel" class="tab-pane support-tab" id="support">
        <div class="row">
            <div class="col col-sm-offset-2 col-sm-8">
                    {!! Form::open(['route' => ['user.contact-support'],'class'=> 'form-horizontal', 'id'=>'contact_support']) !!}
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label for="name" class="col col-sm-4 no-padding control-label">First Name &amp; Last Name</label>
                        <div class="col col-sm-8">
                            <input type="text" class="form-control" name="name" id="name" required placeholder="enter your first &amp; last name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email-address" class="col col-sm-4 no-padding control-label">Email Address</label>
                        <div class="col col-sm-8">
                            <input type="email" class="form-control" name="email" id="email" required placeholder="enter your email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="contact-reason" class="col col-sm-4 no-padding control-label">Reason for Contact</label>
                        <div class="col col-sm-8">
                            <div class="btn-group">
                                {{ Form::select('reason', ['Account'=>'Account','Payment'=>'Payment','Other help'=>'Other help'],null,['class'=>'form-control']) }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="message" class="col col-sm-4 no-padding control-label">Message</label>
                        <div class="col col-sm-8">
                            <textarea id="message" class="form-control" name="message" rows="4" required placeholder="type your message..."></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col col-xs-12">
                            <button type="submit" id="contact_support_button" class="btn btn-success btn-green pull-right btn-send">Send</button>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
        <div class="row">
            <div class="col col-sm-offset-1 col-sm-9">
                <div class="clearfix contact-info">
                    <div class="col col-sm-5">
                        <h5>Live Cosmos LLC</h5>
                        <p>228 Hamilton Ave.<br>3rd Floor.<br>Palo Alto CA, 94301<br>Toll Free: 1-866-994-5907<br>Customer Service: 24/7<br>Holidays May Vary</p>
                    </div>
                    <div class="col col-sm-7">
                        <img src="/images/map.png" alt="" class="img-responsive">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>