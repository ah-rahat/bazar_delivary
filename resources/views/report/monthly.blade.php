@extends('layouts.app')
@section('content')
    @if(Auth::user()->role === 'admin')
        @include('layouts.admin-sidebar')
    @else
        @include('layouts.other-sidebar')
    @endif
    <div class="content-area">
        <div class="container-fluid mt30">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="panel panel-default simple-panel">
                        <div class="panel-heading" style="overflow:hidden;">

                           Monthly Sales 
                           <form method="GET" style="float:right;">
                          
                           <button type="submit" class="btn btn-info" style="float:right;">Submit</button>
                             <select name="month" required>
                                    <option value="1">Jan</option>
                                    <option value="2">Feb</option>
                                    <option value="3">Mar</option>
                                    <option value="4">Apr</option>
                                    <option value="5">May</option>
                                    <option value="6">Jun</option>
                                    <option value="7">Jul</option>
                                    <option value="8">Aug</option>
                                    <option value="9">Sep</option>
                                    <option value="10">Oct</option>
                                    <option value="11">Nov</option>
                                    <option value="12">Dec</option>
                               </select>
                               <input type="year" placeholder="year" required name="year" style="margin-right:10px" />
                               
</form>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped " style="font-size: 14px;">
                                    <thead>
                                    <tr class="text-uppercase">
                                        <td style="font-size: 13px;">order ID</td> 
                                        <td style="font-size: 13px;">order Total</td> 
                                        <td style="font-size: 13px;">Delivery Charge</td> 
                                        <td style="font-size: 13px;">Coupon Discount</td>  
                                         
                                    </tr>
                                    </thead>
                                    <tbody>
                                       
                                        @foreach($orders as $order)
                                        <tr>
                                             <td>#{{ $order->id }}</td>
                                        <td>£{{ $order->order_total }}</td>
                                        <td>£{{ $order->delivery_charge }}</td>
                                        <td>£{{ $order->coupon_discount_amount }}</td> 
                                        
</tr>
                                        @endforeach
                                   
                                    </tbody>
                                </table>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection