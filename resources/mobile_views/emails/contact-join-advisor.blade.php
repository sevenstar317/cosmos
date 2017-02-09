<html>
<body>
Hello <br/><br/>

You have a message from user {{$request->get('first_name')}} {{$request->get('last_name')}}  <br/><br/>

Phone: {{$request->get('phone')}}<br/>
Address: {{$request->get('address')}}<br/>
Email: {{$request->get('email')}}<br/><br/>


{{$request->get('message')}}<br/><br/>


Best Wishes,<br/>
Live Cosmos<br/>
</body>
</html>
