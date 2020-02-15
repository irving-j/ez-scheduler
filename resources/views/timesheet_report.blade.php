@if(Session::has('message'))
    <p class="message" >{{ Session::get('message') }}</p>
@endif
</div>
@isset($employeeTotals)
<button id='print-content' onclick='printContent(\"maincontent\", \"Weekly totals\")'>Print</button>
<table><tr><th>Employee</th><th>{{$startdate1}} - {{$enddate1}}</th><th>{{$startdate2}} - {{$enddate2}}</th><th>Total Hours</th></tr>
@foreach($employeeTotals["totals"] as $totals)
    $week1total = (employeeTotals["totals"][i].week1 != null) ? Number(employeeTotals["totals"][i].week1) : 0;
    $week2total = (employeeTotals["totals"][i].week2 != null) ? Number(employeeTotals["totals"][i].week2) : 0;
    $totalHours = week1total + week2total;
    <tr><td class=''>{{$totals['lastname']}} , {{$totals.name}}</td><td class='amounts'>{{$week1total}}</td><td class='amounts'>{{$week2total}}</td><td class='amounts'>{{$totalHours}}</td></tr>   
    $week1total = 0;
    $week2total = 0;
    $totalHours = 0.00;
@endforeach
</table>
@endisset
