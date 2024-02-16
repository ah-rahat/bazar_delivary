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
                         
                        <div class="area" style="padding-right: 12px;">
								<div  style="margin-bottom: 50px;">
									<img src="https://gopalganjbazar.com/web/images/favo.jpg" alt="invoice icon" style="width: 41px; float: left;" />
									<span style="font-size: 20px;margin-top: 6px;float: left;margin-left: 15px;">
										INVOICE
									</span>
								</div>
								<div style="width: 48%;float: left;">
									<p style="font-size: 12px;margin: 0 0 5px;text-transform: uppercase;" class="color">
									  {{ $order_custumer->name}}
									</p>
									<p style="margin: 0 0 5px;">
								PHONE: <b style="font-size: 14px;letter-spacing: 1px;">{{ $order_custumer->phone}}</b>
									</p>
                                    <p style="margin: 0 0 5px;">
										Order Date:  {{ date(' jS \ F Y h:i A', strtotime($order_custumer->created_at))}} 
									</p>
									<p class="inv_id" style="margin: 0 0 5px;word-break: keep-all;">
										Invoice No:   #{{ $order_custumer->order_id }} &nbsp;
                                        @if($order_custumer->payment_type==1)
                                        Bkash
                                        @elseif($order_custumer->payment_type==2)
                                        C.O.D
                                        @endif
									</p>
									<br />
								</div>
								<div style="text-align: right;float: right; width: 48%;">
									<p style="font-size: 12px;margin: 0 0 5px;" class="color">
										GOPALGANJ BAZAR
									</p>
									<p style="margin: 0 0 5px;">
										Gopalganj City
									</p>
									<p style="margin: 0 0 5px;;">
										Phone:  01931-313141 
									</p>
                                    	<p style="margin: 0 0 5px;">
										Office Copy
									</p>
                                    
									<br />
								</div>
								<div class="productsarea">
									<table class="table">
										<thead>
											<tr>
												<th>
													P.NAME
												</th>
												<th class="text-center" width="70px">
													U.PRICE
												</th>
												<th class="text-center" width="40px">
													QTY
												</th>
												<th style="text-align: right;" class="color">
													SUBTOTAL
												</th>
                                                	<th style="text-align: right;" class="color">
													BUY PRICE
												</th>
											</tr>
										</thead>
										<tbody>
											@foreach ($order_products as $order_product)
											<tr>
												@foreach ($products as $product) @if($order_product->product_id ==$product->id)
												<td style="border-bottom: 1px solid rgb(217, 217, 217) !important ;">
													@if($order_product->custom_name_bn)
														{{$order_product->custom_name_bn}}  

													@else
														{{$product->name_bn}} {{$product->strength}}   <span style="text-transform: capitalize;font-weight: 600;">{{$product->unit_quantity}} {{$product->unit}}</span>

													@endif
														</td>
												@endif @endforeach
												<td class="text-center" style="font-weight: 600;border-bottom: 1px solid rgb(217, 217, 217) !important ;">
													{{ number_format((float)$order_product->unit_price, 2, '.', '') }}  <span class="text-right pull-right">&#215;</span>
												</td>
												<td class="text-center" style="font-weight: 600;border-bottom: 1px solid rgb(217, 217, 217) !important ;">
													{{ $order_product->quantity }}
												</td>
												<td class="color" style="border-bottom: 1px solid rgb(217, 217, 217) !important ; padding-right: 15px !important; text-align: right;color: #e05544;font-weight: 600;">
													&#2547;   {{ number_format((float)$order_product->total_price, 2, '.', '') }}
												</td>
                                                <td class="text-center" style="border-left: 1px solid #d9d9d9 !important;border-bottom: 1px solid rgb(217, 217, 217) !important ;" >
												 
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
													SUB TOTAL
												</td>
												<td style="padding-right: 15px !important;text-align: right;color: #e05544;font-weight: 600;" class="color">
													&#2547;   {{ number_format((float)$order_custumer->order_total, 2, '.', '') }}
												</td>
											</tr>
											<tr>
												<td colspan="3" class="text-right">
													DELIVERY CHARGE
												</td>
												<td style="padding-right: 15px !important;text-align: right;color: #e05544;font-weight: 600;" class="color">
													&#2547;    {{ number_format((float)$order_custumer->delivery_charge, 2, '.', '') }}
												</td>
											</tr>
											<tr>
												<td colspan="3" class="text-right">
													DISCOUNT
												</td>
												<td style="padding-right: 15px !important;text-align: right;color: #e05544;font-weight: 600;" class="color">
													&#2547;  {{ number_format((float)$order_custumer->coupon_discount_amount, 2, '.', '') }}
												</td>
											</tr>
											<tr >
												<td colspan="3" class="text-right" style="font-weight: bold;color: #e05544;">
													TOTAL
												</td>
												<td style="padding-right: 15px !important;text-align: right;color: #e05544;font-weight: 600; border-top: 1px dashed #ccc !important;" class="color">
													&#2547;  
                                                    {{ number_format((float)$order_custumer->order_total + $order_custumer->delivery_charge - $order_custumer->coupon_discount_amount, 2, '.', '') }}
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
												DELIVERY ADDRESS:
											</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>
                                            {{ $order_custumer->address}} ,  {{ $order_custumer->area}}
												
											</td>
										</tr>
									</tbody>
								</table>
								<table class="table">
									<tbody>
										<tr>
										<td style="border-bottom: 1px dashed #ccc !important;width: 180px;font-size: 12px;">
												DOKAN SIGNATURE'S
											</td>
											<td>
											</td>
										</tr>
									</tbody>
								</table>
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
    padding: 2px 0 !important;
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