@extends('layouts.app') @section('content') @if(Auth::user()->role === 'admin') @include('layouts.admin-sidebar') @else @include('layouts.other-sidebar') @endif
<div class="content-area">
 
	<div class="container-fluid mt30">
		<div class="row justify-content-center">
			<div style="width: 400px;display: none;">
				<canvas id="MeSeStatusCanvas">
				</canvas>
			</div>
              @if(Auth::user()->role!='vendor')   
			<div class="col-md-12">
				<div class="panel">
					<div class="panel-body">
						<canvas id="myChart">
						</canvas>
					</div>
				</div>
			</div>
		     @else
             <div class="col-md-12">
				<div class="panel">
					<div class="panel-body">
					 Wlcome: {{ Auth::user()->name}}
					</div>
				</div>
			</div>
            @endif
			<script>
				
function daysInMonth (month, year) {
  return new Date(year, month, 0).getDate();
}
var year= moment().format('YYYY')
var month=moment().format('M')
//console.log(daysInMonth(month,year));
var totalDays=daysInMonth(month,year); 
var arr = [];

for (var i = 1; i < totalDays+1; i++) {
    arr.push(i);
}
 console.log(arr.to);
var canvas = document.getElementById('myChart');
var data = {
    labels: [
        @foreach ($sales as $sale)
      {{ date('d', strtotime($sale->date))}},
            @endforeach
    ],
    datasets: [
        {
            label: "Daily Sales Report",
           backgroundColor: "rgba(255,99,132,0.2)",
            borderColor: "rgba(255,99,132,1)",
            borderWidth: 1,
            hoverBackgroundColor: "rgba(255,99,132,0.4)",
            hoverBorderColor: "rgba(255,99,132,1)",
            data: [
             @foreach ($sales as $sale)
      {{ $sale->order_total+$sale->delivery_charge-$sale->coupon_discount_amount}},
            @endforeach
            ],
        }
    ]
};
var option = {
animation: {
				duration:5000
}

};


var myBarChart = Chart.Bar(canvas,{
	data:data,
  options:option
});


   

			</script>
		<!--<div class="col-md-7">-->
  <!--<div class="panel recent-orders">-->
    <!--<div class="panel-heading">-->
      <!--Last Orders-->
    <!--</div>-->
    <!--<div class="panel-body">-->
      <!--<div class="table-responsive">-->
        <!--<table class="table table-style1">-->
          <!--<thead>-->
          <!--<tr>-->
            <!--<th scope="col">-->
              <!--ID-->
            <!--</th>-->
            <!--<th scope="col">-->
              <!--O.Time-->
            <!--</th>-->
            <!--<th scope="col">-->
              <!--Amount-->
            <!--</th>-->
            <!--<th scope="col">-->
              <!--Phone-->
            <!--</th>-->
          <!--</tr>-->
          <!--</thead>-->
          <!--<tbody>-->
          <!--@foreach($orders as $order)-->
          <!--<tr>-->
            <!--<td>-->
              <!--@if(Auth::user()->role='admin')-->
              <!--<a class="base-color" href="ad/order/{{$order->order_id}}">#{{ $order->order_id }}</a>-->
              <!--@else-->
              <!--<a class="base-color" href="pm/order/{{$order->order_id}}">#{{ $order->order_id }}</a>-->
              <!--@endif-->

            <!--</td>-->
            <!--<td>-->

              <!--{{ date('M d  h:i a', strtotime($order->created_at))}}-->

            <!--</td>-->
            <!--<td>-->
              <!--{{ $order->order_total+$order->delivery_charge }}-->
            <!--</td>-->
            <!--<td>-->
              <!--{{ $order->phone }}-->
            <!--</td>-->

          <!--</tr>-->
          <!--@endforeach-->
          <!--</tbody>-->
        <!--</table>-->
      <!--</div>-->
    <!--</div>-->
  <!--</div>-->
<!--</div>-->
<!--<div class="col-md-5">-->
  <!--<div class="panel recent-orders">-->
    <!--<div class="panel-heading">-->
      <!--Low Stock Products-->
    <!--</div>-->
    <!--<div class="panel-body">-->
      <!--<table class="table table-style1">-->
        <!--<thead>-->
        <!--<tr>-->
          <!--<th scope="col">-->
            <!--ID-->
          <!--</th>-->
          <!--<th scope="col">-->
            <!--Product name-->
          <!--</th>-->
          <!--<th scope="col">-->
            <!--R.Quantity-->
          <!--</th>-->
        <!--</tr>-->
        <!--</thead>-->
        <!--<tbody>-->
        <!--@foreach($products as $product)-->
        <!--<tr>-->
          <!--<td>-->
            <!--<a class="base-color" href="">{{$product->id}}</a>-->
          <!--</td>-->
          <!--<td>-->
										<!--<span class=" ">-->
										<!--{{$product->name}}-->
										<!--</span>-->
          <!--</td>-->
          <!--<td>-->
            <!--{{$product->stock_quantity}} 	{{$product->unit}}-->
          <!--</td>-->
        <!--</tr>-->
        <!--@endforeach-->
        <!--</tbody>-->
      <!--</table>-->
    <!--</div>-->
  <!--</div>-->
<!--</div>-->
		</div>
	</div>
</div>
@endsection