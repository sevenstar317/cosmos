<html>
<head>
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400" rel="stylesheet">
</head>
<body style=" font-family: 'Lato', sans-serif;">
<div id="outer_top" style="width:100%;background-color:#4cbad7;color:white;">
    <div id="inner" style="text-align:center; width: 40%;   margin: 0 auto;  padding-top:30px;">
      <!--  <div id="top_image_1" style="position:absolute;          left:50%;          top:10%;">
            <img src="https://livecosmos.com/images/Layer-12.png" />
        </div>
        <div id="top_image_2" style="  position:absolute;          left:45%;           top:11%;">
            <img src="https://livecosmos.com/images/Layer-13.png" />
        </div>
        <div id="top_image_3" style=" position:absolute;            left:55%;            top:9%;">
            <img src="https://livecosmos.com/images/Layer-13.png" />
        </div>
        <div id="top_image_4" style="  position:absolute;            left:52%;            top:8%;">
            <img src="https://livecosmos.com/images/Layer-13.png" />
        </div>
        <div id="top_image_5" style="position:absolute;            left:48%;            top:14%;">
            <img src="https://livecosmos.com/images/Layer-13.png" />
        </div>
        <div id="top_image_6" style="  position:absolute;            left:51%;            top:15%;">
            <img src="https://livecosmos.com/images/Layer-13.png" />
        </div>
        !-->
        <div id="top_image" style="text-align:center;">
            <img src="https://livecosmos.com/images/Layer-5.png" />
        </div>
        <div id="top_rect" style="  text-align:center;  padding-top:15px;  min-width: 140px;   padding-bottom: 60px;">
            <div id="welcome" style=" font-size:26pt;            font-weight:bold;            padding-bottom:10px;">
                Your Live Cosmos Latest Receipt!
            </div>
            <div id="we_glad" style=" font-size:20pt;">
                Your Order for  "{{$responce['description']}}" Has Been Accepted
            </div>
        </div>

    </div>
</div>
<div id="outer_bottom" style="width:100%;background-color:white;color:black;">
    <div id="inner" style="text-align:center;   width: 50%;   margin: 0 auto;      padding-top:30px;">
        <div id="bottom_up" style="  width:100%;  background-color:white;  border-radius: 20px 20px 0px 0px; -moz-border-radius: 20px 20px 0px 0px; -webkit-border-radius: 20px 20px 0px 0px;">
            <div id="your_det" style="font-size:22pt; font-weight:bold;"> Email Receipt for {{$user->getFullName()}}</div>
            <br/>
            <div id="info" style=" font-size:22pt; text-align:left; font-weight:300; margin: 0 auto;  max-width: 450px;">
                {{$responce['description']}} -  ${{$responce['total']}}
                <br/>
                {{date('m/d/Y')}}
            </div>

            <div id="add_info" style="   background-color:#ebebeb;  padding:15px;     margin-top:40px;     font-weight:300;      line-height:20pt;">
                Need Additional Information?<br/>
                Please contact us 24/7 at 1.866.994.5907 or hello@livecosmos.com
            </div>

        </div>
    </div>
</div>
</body>
</html>
