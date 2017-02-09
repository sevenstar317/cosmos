<html>
<body>
Hello <br/><br/>

You have a message from user {{$request->get('name')}} about {{$request->has('reason')?$request->get('reason'):''}} <br/><br/>

{{$request->get('message')}}<br/><br/>


Best Wishes,<br/>
Live Cosmos<br/>
</body>
</html>
