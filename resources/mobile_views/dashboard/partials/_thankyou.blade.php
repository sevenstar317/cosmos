<!-- Modal -->
<div class="modal fade" id="thankyou-modal-id" tabindex="-1" role="dialog" aria-labelledby="thankyou-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Welcome to Live Cosmos!</h4>
            </div>
            <div class="modal-body text-center">
                <div class="headline">Your Live Session is about to Begin! <span>Please save your new password</span></div>
                <div class="user-info">
                    <div class="user-info-inner">
                        <div class="user-email"><span>User: </span>{{\Illuminate\Support\Facades\Auth::user()->email}}</div>
                        <div class="user-password"><span>Password: </span>{{\Illuminate\Support\Facades\Auth::user()->real_password}}</div>
                    </div>
                </div>
                <?php
                $m = explode(':',\Illuminate\Support\Facades\Auth::user()->minutes_balance);
                    if(isset($m[1])){
                        $pa = $m[1];
                    }else{
                    $pa = 'n/a';
                }
                ?>

                <div class="subline">Your Account is Now Active | <span>Credits:</span> {{(Auth::user()->minutes_balance != '00:00:00') ? $pa : '0'}} Minutes</div>
            </div>
            <div class="modal-footer">For Questions and Answers Please contact us at: <strong>1-877-948-94940</strong></div>
        </div>
    </div>
</div>



@if (session('new-user'))
    <!-- Google Code for Purchase Conversion Page -->
    <script type="text/javascript">
        /* <![CDATA[ */
        var google_conversion_id = 878871257;
        var google_conversion_language = "en";
        var google_conversion_format = "3";
        var google_conversion_color = "ffffff";
        var google_conversion_label = "-_HSCPHtlmoQ2YWKowM";
        var google_remarketing_only = false;
        /* ]]> */
    </script>
    <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
    </script>
    <noscript>
        <div style="display:inline;">
            <img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/878871257/?label=-_HSCPHtlmoQ2YWKowM&amp;guid=ON&amp;script=0"/>
        </div>
    </noscript>
    <script type="text/javascript">
        $('#thankyou-modal-id').modal('show');
    </script>


@endif