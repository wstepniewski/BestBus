

<h1>
    {{ $ticket->cityFrom." - > ".$ticket->cityTo }}
</h1>



{{--<img src="{{ public_path('qrcode.png') }}" style="width: 200px; height: 200px">--}}
{{--<img src="{{public_path('qrcode.jpg') }}" >--}}

<table style="border: solid 1px #aaa999;">
    <tr>
        <th style="border: solid 1px #aaa999;"> From </th>
        <th style="border: solid 1px #aaa999;"> To </th>
        <th style="border: solid 1px #aaa999;"> Departure </th>
        <th style="border: solid 1px #aaa999;"> Arrival </th>
        <th style="border: solid 1px #aaa999;"> Date </th>
        <th style="border: solid 1px #aaa999;"> Price </th>
    </tr>
    <tr>
        <th style="border: solid 1px #aaa999;"> {{ $ticket->cityFrom }} </th>
        <th style="border: solid 1px #aaa999;"> {{ $ticket->cityTo }} </th>
        <th style="border: solid 1px #aaa999;"> {{ $ticket->departure }} </th>
        <th style="border: solid 1px #aaa999;"> {{ $ticket->arrival }} </th>
        <th style="border: solid 1px #aaa999;"> {{ $ticket->day }} </th>
        <th style="border: solid 1px #aaa999;"> {{ $ticket->price }} PLN </th>
    </tr>
</table>





