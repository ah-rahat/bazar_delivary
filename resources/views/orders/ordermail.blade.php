<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html" />
		<meta name="author" content="gopalganjbazar" />
		<title>
			Order Invoice
		</title>
	</head>
	<body>
		<div style="overflow-x: auto;max-width: 600px;font-family: verdana;font-size: 13px;  ; margin:50px auto auto auto; border: 1px solid #eaeaea;border-top: 3px solid #e82d77;border-radius: 3px;padding: 30px 15px;box-shadow: 0px 0px 4px #d5d5d5;">
			<div>
				<img src="https://gopalganjbazar.com/static/img/gopalgonjbazar-logo.69a19e5.png" height="50px" style="margin: auto;display: block;" />
				<h3 style="display: block;text-align: center;margin: 32px 0 25px 0px;">
					ORDER INVOICE
				</h3>
			</div>
			<table style="width: 100%;text-align: left;border: 1px solid #8e8e8e1c;">
				<thead>
					<tr>
						<th style="padding: 15px 10px;text-transform: uppercase;font-weight: 500;">
							Product Name
						</th>
						<th style="padding: 15px 10px;text-transform: uppercase;font-weight: 500;">
							Unit Price
						</th>
						<th style="padding: 15px 10px;text-transform: uppercase;font-weight: 500;">
							Quantity
						</th>
						<th style="padding: 15px 10px;text-transform: uppercase;font-weight: 500;">
							Total
						</th>
					</tr>
				</thead>
				<tbody>
					@foreach($orders as $order)
					<tr>
						<td style="padding: 15px 10px;border-top: 1px solid #8e8e8e1f;border-right: 1px solid #8e8e8e1f;">
							{{ $order->product_name}}  {{ $order->unit_quantity}} {{ $order->unit}}
						</td>
					<td style="padding: 15px 10px;border-top: 1px solid #8e8e8e1f;border-right: 1px solid #8e8e8e1f;">
							&#2547;{{$order->unit_price}}
						</td>
						<td  style="text-align: center; padding: 15px 10px;border-top: 1px solid #8e8e8e1f;border-right: 1px solid #8e8e8e1f;">
							{{ $order->quantity}}
						</td>
						<td style="padding: 15px 10px;border-top: 1px solid #8e8e8e1f;color: #41c300;">
							&#2547;{{$order->total_price}}
						</td>
					</tr>
					@endforeach 
					<tr>
						<td colspan="3" style="text-align: right;padding: 15px 10px;border-top: 1px solid #8e8e8e1f;border-right: 1px solid #8e8e8e1f;">
							Delivery Charge:
						</td>
						<td style="padding: 15px 10px;border-top: 1px solid #8e8e8e1f; color: #41c300;">
							&#2547;{{ $orders->first()->delivery_charge }} 
						</td>
					</tr>
					<tr>
						<td colspan="3" style="text-align: right;padding: 15px 10px;border-top: 1px solid #8e8e8e1f;border-right: 1px solid #8e8e8e1f;">
							Discount:
						</td>
						<td style="padding: 15px 10px;border-top: 1px solid #8e8e8e1f;color: #fb8c00;">
							&#2547;{{$orders->first()->coupon_discount_amount }} 
						</td>
					</tr>
					<tr>
						<td colspan="3" style="text-align: right;padding: 15px 10px;border-top: 1px solid #8e8e8e1f;border-right: 1px solid #8e8e8e1f;">
							Total:
						</td>
						<td style="padding: 15px 10px;border-top: 1px solid #8e8e8e1f; color: #41c300;">
							&#2547;{{$orders->first()->order_total+$orders->first()->delivery_charge-$orders->first()->coupon_discount_amount }} 
						</td>
					</tr>
                    	<tr>
						<td colspan="4" style=";padding: 15px 10px;border-top: 1px solid #8e8e8e1f;border-right: 1px solid #8e8e8e1f;">
						 Order Created By: {{ $userinfo->name}}
						</td>
						
					</tr>
				</tbody>
			</table>
            
           
		</div>
	</body>

</html>