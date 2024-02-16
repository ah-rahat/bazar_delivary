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
                        <div class="panel-heading">

                            Today Sold Products Buy Price check list

                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped " style="font-size: 14px;">
                                    <thead>
                                    <tr class="text-uppercase">
                                        <td style="font-size: 13px;">#order id</td>
                                        <td style="font-size: 13px;">Product Name</td>
                                        <td style="font-size: 13px;background: #ffecb3;"> Buy Price</td>
                                        <td style="font-size: 13px;background: #c5e1a5;"> Sale Price</td>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            @if(Auth::user()->role === 'admin')
                                                <td><a style="color: #e91e63;" target="_blank" href="/web/ad/order/{{$order->order_id}}">#{{$order->order_id}}</a></td>
                                            @else
                                                <td><a style="color: #e91e63;" target="_blank" href="/web/pm/order/{{$order->order_id}}">#{{$order->order_id}}</a></td>
                                            @endif
                                            <td>
                                                {{$order->name}} - {{$order->unit_quantity}}{{$order->unit}} <br>
                                                <small>{{$order->name_bn}} - {{$order->unit_quantity}}{{$order->unit}}</small>
                                            </td>
                                            <td style="background: #ffecb3;">{{$order->total_buy_price}}</td>
                                            @if($order->total_buy_price > $order->total_price)
                                                <td style="background: #ffecb3; color: #e91e63;font-weight: bold;">{{$order->total_price}}</td>
                                            @else
                                                <td style="background: #c5e1a5;">{{$order->total_price}}</td>
                                            @endif
                                        </tr>
                                    @endforeach
                                    @foreach($orders_discount as $discount)
                                        <tr>
                                            @if(Auth::user()->role === 'admin')
                                                <td><a style="color: #e91e63;" target="_blank" href="/web/ad/order/{{$discount->id}}">#{{$discount->id}}</a></td>
                                            @else
                                                <td><a style="color: #e91e63;" target="_blank" href="/web/pm/order/{{$discount->id}}">#{{$discount->id}}</a></td>
                                            @endif
                                            <td>
                                                Order Discount
                                            </td>
                                            <td style="background: #ffecb3;" colspan="2">{{$discount->coupon_discount_amount}}</td>

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