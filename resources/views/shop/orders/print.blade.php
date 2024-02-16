<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- CSRF Token -->
	<meta name="csrf-token" content="cHOB9yjUHxOpcQC9bcdk1fDZbo6FeIrmCsHu1X3H">
	<title>
		Print Order
	</title>
	<!-- Scripts -->
	<script src="https://gopalganjbazar.com/web/js/app.js" defer>
	</script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<!-- Fonts -->
	<link rel="dns-prefetch" href="//fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Lato&family=Quicksand:wght@500;515&family=Raleway:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">
	<script src="https://use.fontawesome.com/b95bd32606.js">
	</script>

	<link href="https://gopalganjbazar.com/web/css/style.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Gruppo&display=swap" rel="stylesheet">

	<link href="https://fonts.googleapis.com/css2?family=Codystar&family=Raleway+Dots&family=Snippet&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Life+Savers&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Snippet&display=swap" rel="stylesheet">
	<!--     font-family: 'Snippet', sans-serif; font-family: 'Snippet', sans-serif;-->
	<style>
		body,table,tr,td,p,span,div{
			font-family: revert;
			color: #000;
			text-shadow: none;
			opacity: 1;
            font-size: 11px;
		}
	</style>
	<script src="https://use.fontawesome.com/f2988b3c12.js">


	</script>
</head>
<body style="background: #fff;">
<span     class="btn btn-block btn-sm btn-info printMe" style="border-radius: 0px;background: #e05544;border: 1px solid #de3c31;padding: 5px 0;font-size: 16px;"><i class="fa fa-print" aria-hidden="true"></i> PRINT INVOICE</span>
<div id="app">
	<main>
		<div>
			<div class="container-fluid">
				<div class="justify-content-center">

					<div class="toparea">
						<div class="text-center"  style="margin-bottom: 10px;">
							<h3 style="margin: auto;
font-family: Rajon Shoily;
padding: 0px;
width: fit-content;
font-size: 23px;
color: #000;
font-weight: 500;
line-height: 19px;
opacity: 1;">গোপালগঞ্জ বাজার.কম <br>
							<small style="    font-size: 16px;color: #000;">বাজার  করুন ঘরে বসে </small>
							</h3>
{{--							<img src="https://gopalganjbazar.com/web/images/favo.jpg" alt="invoice icon" style="width: 41px;" />--}}

{{--							<span style="font-size: 20px;margin-top: 6px;">--}}
{{--										INVOICE--}}
{{--									</span>--}}
						</div>

						<div style="text-align: right">
							<p style="font-size: 12px;
margin: 10px 0px 0px;
text-transform: uppercase;
width: 100%;" class="color">
								{{ $order_custumer->name}}
							</p>
							<p style="margin: 0 0 0px;">
								 <span style="font-size: 12px;letter-spacing: 1px;">{{ $order_custumer->phone}}</span>
							</p>
							<p style="margin: 0 0 0px;">
								  {{ date(' jS \ M h:i A', strtotime($order_custumer->created_at))}}
							</p>
							<p class="inv_id" style="word-break: keep-all;text-align: right;float: right">
								   #{{ $order_custumer->order_id }}
								@if($order_custumer->payment_type==1)
									Bkash
								@elseif($order_custumer->payment_type==2)
									C.O.D
								@endif

							</p>
							<br />
						</div>
						<div class="productsarea">
							<table class="table">

								<tbody>
								@foreach ($order_products as $order_product)
									<tr>
										@foreach ($products as $product) @if($order_product->product_id ==$product->id)
											<td colspan="3">
												@if($order_product->custom_name_bn)
													{{$order_product->custom_name_bn}}
												@else
												{{$product->name_bn}} {{$product->strength}} {{$product->unit_quantity}} {{$product->unit}}  <span style="text-transform: capitalize;">
												@endif
												@if($product->restaurant_id)
													<br />

														@foreach ($restaurents as $restaurent)
															@if($product->restaurant_id == $restaurent->id)
																{{$restaurent->restaurant_name_bn}}
															@endif
														@endforeach

												@endif
													<br>   {{ $order_product->quantity }}	&#215; &#2547;{{ number_format((float)$order_product->unit_price, 2, '.', '') }}

											</td>
										@endif

										@endforeach
											<td>
												<span  style="text-transform: capitalize;float: right;text-align: right;">    &#2547;{{number_format((float)$order_product->total_price, 2, '.', '') }} </span>

											</td>
									</tr>
								@endforeach
								<tr>
									<td colspan="3" class="text-right">
									</td>
									<td>
									</td>
								</tr>
								<tr>
									<td colspan="3" class="text-right">
										সাব টোটাল
									</td>
									<td style="text-align: right;color: #e05544;font-weight: 600;" class="color">
										&#2547;{{number_format((float)$order_custumer->order_total, 2, '.', '') }}
									</td>
								</tr>
								<tr>
									<td colspan="3" class="text-right">
										ডেলিভারি চার্জ
									</td>
									<td style="text-align: right;color: #e05544;font-weight: 600;" class="color">
										&#2547;{{number_format((float)$order_custumer->delivery_charge, 2, '.', '') }}
									</td>
								</tr>
								<tr>
									<td colspan="3" class="text-right">
										ডিসকাউন্ট
									</td>
									<td style="text-align: right;color: #e05544;font-weight: 600;" class="color">
										&#2547;{{number_format((float)$order_custumer->coupon_discount_amount, 2, '.', '') }}
									</td>
								</tr>
								<tr >
									<td colspan="3" class="text-right" style="font-weight: bold;color: #e05544;">
										মোট
									</td>
									<td style="text-align: right;color: #e05544;font-weight: 600; border-top: 1px dashed #ccc !important;" class="color">
										&#2547;{{number_format((float)$order_custumer->order_total + $order_custumer->delivery_charge - $order_custumer->coupon_discount_amount, 2, '.', '') }}
									</td>
								</tr>
								<tr>
								</tr>
								</tbody>
							</table>
						</div>
						<table class="table">
							<thead>
							<tr>
								<th>
									ডেলিভারি ঠিকানা:
								</th>
							</tr>
							</thead>
							<tbody>
							<tr>
								<td>
									 এরিয়া:{{ $order_custumer->area}}<br>
									ঠিকানা: {{ $order_custumer->address}}

								</td>
							</tr>
							</tbody>
						</table>
{{--						<table class="table">--}}
{{--							<tbody>--}}
{{--							<tr>--}}
{{--								<td style="border-bottom: 1px dashed #ccc !important;width: 180px;font-size: 12px;">--}}
{{--									ক্রেতার স্বাক্ষর--}}
{{--								</td>--}}
{{--								<td>--}}
{{--								</td>--}}
{{--							</tr>--}}
{{--							</tbody>--}}
{{--						</table>--}}
					</div>
 				</div>
			</div>
		</div>
	</main>
</div>

<style type="text/css" media="print">

	@page
	{
		size: auto;   /* auto is the initial value */
		margin: 0mm;  /* this affects the margin in the printer settings */
	}
	#app{
		max-width: inherit !important;
		margin: 0;
	}
	.printMe{
		visibility: hidden;
	}
	.toparea{
		margin-top: -30px;
	}
	.productsarea{
		margin-top: 30px;
	}

	.container-fluid{
		padding: 0 !important;
	}
	p.inv_id{
		word-break: keep-words !important;
		color: red;
		width: 150px;
	}
	.color{
		font-weight: 400 !important;
	}

	.table > thead > tr > th {
		font-size: 12px;
	}

</style>
<style>
	#app{
		max-width: 320px;
		margin: auto;
	}


	.table > thead > tr > th {
		vertical-align: top;
		border-bottom: 1px solid #ddd;
		padding: 2px 0 !important;
		font-weight: 500;
	}
	.table > tbody > tr > td {
		vertical-align: top !important;
		padding: 2px 0 !important;
	}

	table,tr,td {
		padding: 0;
	}
	table td{
		border: none !important;
	}

</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js">
</script>
<!-- <script src="https://web.gopalganjbazar.com/public/js/jquery.min.js"></script>-->
<!-- include summernote css/js-->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous">
</script>
<script>
	$('.printMe').click(function() {
		window.print();
		return false;
	});

</script>
</body>
<style>

</style>
</html>