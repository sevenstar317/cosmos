<html>
<body>
Hello <br/><br/>

Here is your chat history:<br/><br/>

@forelse($messages as $message)
    <ul>
    @if($message->message != "---------------- Client left the room, You can close the chat. ------------------" )
        @if($message->sender_type == 'agent')
                <li style="color: darkblue">{{ $message->message }}</li>
            @else
                <li style="color: black">{{ $message->message }}</li>
            @endif

    @endif
    </ul>

@empty

    <p>No messages</p>

@endforelse

Best Wishes,<br/>
Live Cosmos<br/>
</body>
</html>
