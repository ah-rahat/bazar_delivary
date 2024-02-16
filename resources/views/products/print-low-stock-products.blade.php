<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- CSRF Token -->
	<meta name="csrf-token" content="cHOB9yjUHxOpcQC9bcdk1fDZbo6FeIrmCsHu1X3H">
	<title>
		Need Stock Products
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
			font-family: 'Gruppo', cursive;
			color: #000;
			text-shadow: none;
			opacity: 1;
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
			<div class="container-fluid mt30">
				<div class="justify-content-center">

					<div class="area">
						<div  style="margin-bottom: 50px;">
							<img src="https://gopalganjbazar.com/web/images/favo.jpg" alt="invoice icon" style="width: 41px; float: left;" />

							<span style="font-size: 20px;margin-top: 6px;float: left;margin-left: 15px;">
										Low Stock Products
									</span>
						</div>
						<div style="float: left;">

							<p style="margin: 0 0 5px;">
								  Date:  {{ date(' jS \ F Y h:i A')}}
							</p>

							<br />
						</div>

						<div class="productsarea">
							<table class="table">
								<thead>
								<tr>
									<th>
										ID
									</th>
									<th>
										P.NAME
									</th>

									<th class="text-center" width="200px">
										AVAIAVLE QUANTITY
									</th>
									<th>WAITING </th>

								</tr>
								</thead>
								<tbody>



										@foreach ($products as $product)
											@if($product->stock_quantity <= $product->low_quantity)
												<tr>
											<td>
												<a style="color: #e05544"  target="_blank" href="https://gopalganjbazar.com/web/ad/products/{{$product->id}}">{{$product->id}}</a>
											</td>

											<td>
												{{$product->name_bn}}   <span style="text-transform: capitalize;font-weight: 600;">{{$product->unit_quantity}} {{$product->unit}}</span>

											</td>
											<td class="text-center" style="color: #e05544;font-size: 13px;font-weight: 600;"> 	{{$product->stock_quantity}}
											</td>
													<td class="text-center">
														@foreach($waiting_products as $waiting_product)
															@if($product->id == $waiting_product->product_id)
                                                                    <span style="color: #aa0e74;
font-size: 9px;text-transform: uppercase;border: 1px solid #aa0e74;padding: 3px 5px;font-weight: bold;border-radius: 2px;">Waiting</span>
															@endif
														@endforeach

													</td>
												</tr>
											@endif

										@endforeach




								</tbody>
							</table>
						</div>

					</div>
{{--					<div class="area">--}}
{{--						<div  style="margin-bottom: 50px;">--}}
{{--							<img src="https://gopalganjbazar.com/web/images/favo.jpg" alt="invoice icon" style="width: 41px; float: left;" />--}}

{{--							<span style="font-size: 20px;margin-top: 6px;float: left;margin-left: 15px;">--}}
{{--										Out of  Stock Products--}}
{{--									</span>--}}
{{--						</div>--}}
{{--						<div style="float: left;">--}}

{{--							<p style="margin: 0 0 5px;">--}}
{{--								Date:  {{ date(' jS \ F Y h:i A')}}--}}
{{--							</p>--}}

{{--							<br />--}}
{{--						</div>--}}

{{--						<div class="productsarea">--}}
{{--							<table class="table">--}}
{{--								<thead>--}}
{{--								<tr>--}}
{{--									<th>--}}
{{--										ID--}}
{{--									</th>--}}
{{--									<th>--}}
{{--										P.NAME--}}
{{--									</th>--}}

{{--									<th class="text-center" width="200px">--}}
{{--										AVAIAVLE QUANTITY--}}
{{--									</th>--}}

{{--								</tr>--}}
{{--								</thead>--}}
{{--								<tbody>--}}



{{--								@foreach ($outOfStockProducts as $product)--}}

{{--										<tr>--}}
{{--											<td>--}}
{{--												<a  style="color: #e05544" target="_blank" href="https://gopalganjbazar.com/web/ad/products/{{$product->id}}">{{$product->id}}</a>--}}
{{--											</td>--}}

{{--											<td>--}}
{{--												{{$product->name_bn}}   <span style="text-transform: capitalize;font-weight: 600;">{{$product->unit_quantity}} {{$product->unit}}</span>--}}

{{--											</td>--}}
{{--											<td class="text-center" style="color: #e05544;font-size: 13px;font-weight: 600;"> 	{{$product->stock_quantity}}--}}
{{--											</td>--}}
{{--										</tr>--}}

{{--								@endforeach--}}




{{--								</tbody>--}}
{{--							</table>--}}
{{--						</div>--}}

{{--					</div>--}}





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
	.printMe{
		visibility: hidden;
	}
	.area{
		margin-top: -40px;
	}
	.productsarea{
		margin-top: 30px;
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
		font-size: 11.5px;
	}

</style>
<style>

	.table > thead > tr > th {
		vertical-align: bottom;
		border-bottom: 1px solid #ddd;
		padding: 2px 0 !important;
		font-weight: 500;
	}
	.table > tbody > tr > td {
		padding: 4px 0 !important;
	}
	.area{
		width: 50%;
		float: left;
		display: inline-table;
		font-size: 12px;
	}
	table,tr,td {
		padding: 0;
	}
	table td{
		border: none !important;
		border-bottom: 1px solid #b3b3b3d6 !important;
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

</html>