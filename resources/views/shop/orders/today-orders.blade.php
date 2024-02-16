@extends('layouts.app')
@section('content')
    @if(Auth::user()->role === 'admin')
        @include('layouts.admin-sidebar')
    @else
        @include('layouts.shop-sidebar')
    @endif
    <div class="content-area">
        <div class="container-fluid mt30">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="panel panel-default simple-panel">
                        <div class="panel-heading">
                            @if($date)
                                Order's Lists on {{$date}}
                            @else
                                Today Order Lists
                            @endif
{{--                                <a target="_blank" href="today-orders/{{date('Y-m-d',strtotime("-1 days"))}}" class="btn btn-sm btn-warning pull-right">PREVIOUS DAY ORDERS</a>--}}
                                @if(Auth::user()->role === 'admin')
                                    <a target="_blank" href="today-orders/delivered/{{date('Y-m-d',strtotime("-1 days"))}}" class="btn btn-sm btn-success pull-right mr15">TODAY DELIVERED ORDERS</a>

                                @else
                                    <a target="_blank" href="today-orders/delivered/{{date('Y-m-d',strtotime("-1 days"))}}" class="btn btn-sm btn-success pull-right mr15">TODAY DELIVERED ORDERS</a>

                                @endif
                                  </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table id="example" class="table table-striped " style="font-size: 14px;">
                                    <thead>
                                    <tr class="text-uppercase">
                                        <td style="font-size: 13px;">#order id</td>
                                        <td style="font-size: 13px;">Amount</td>
                                        <td style="font-size: 13px;"> customer    </td>

                                        <td style="font-size: 13px;"> O.Date  </td>
                                        <td style="font-size: 13px;" title="Customer Received Order Time"> C.R.Date  </td>
                                        <td  style="font-size: 13px;" class="text-center">Status  </td>
                                        <td>     </td>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach ($orders  as $order)
                                        <tr>
                                            <td class="bolder">


                                                    <a style="color: #388e3c;" href="http://mmmethod.net/shop/shop/order/{{$order->order_id}}">#{{$order->order_id}}
                                                        @if($order->coupon)
                                                            <small style="text-transform: uppercase;"> - {{$order->coupon}}</small>
                                                        @endif
                                                    </a>


                                            </td>
                                            <td>{{$order->order_total + $order->delivery_charge - $order->coupon_discount_amount}}</td>
                                            <td>{{$order->name}} - <small>{{$order->phone}}</small></td>

                                            <td>
                                                @if($order->created_at)
                                                    {{ date('M d h:i a', strtotime($order->created_at)) }}
                                                @endif
                                            </td>
                                            <td>
                                                {{--                                          @if($order->delivered_date)--}}
                                                {{--                                             {{ date('M d h:i a', strtotime($order->delivered_date)) }}--}}
                                                {{--                                           @endif--}}
                                                @if($order->c_order_received)
                                                    {{ date('M d h:i a', strtotime($order->c_order_received)) }}
                                                @endif
                                            </td>
                                            <td class="text-center" style="font-size: 12px;">
                                                @if($order->active_status==0)
                                                    <span style="blue">  Pending</span>
                                                @elseif($order->active_status==1)
                                                    <span style="background:#fff9c4;color: #fbc02d;padding: 3px 6px;border: 1px solid #8080801c;border-radius: 2px;"> Approved</span>
                                                @elseif($order->active_status==2)
                                                    <span style="background:#efebe9;color: #6d4c41;padding: 3px 6px;border: 1px solid #8080801c;border-radius: 2px;"> In Transit</span>
                                                @elseif($order->active_status==3)
                                                    <span style="color: #388e3c;background: #c8e6c9;padding: 3px 6px;border-radius: 2px;
border: 1px solid #81c784;"> Delivered</span>
                                                @elseif($order->active_status==4)
                                                    <span style="background:#feedef;color: #ef2f45;padding: 3px 6px;border: 1px solid #ef9a9a;border-radius: 2px;"> Cancel</span>
                                                @endif
                                            </td>
                                            <td class="text-center  ">

                                   <a style="color: rgb(56, 142, 60);
background: rgb(200, 230, 201) none repeat scroll 0% 0%;
padding: 3px 6px;
border-radius: 2px;
border: 1px solid rgb(129, 199, 132);" title="Order Details" target="_blank" href="http://mmmethod.net/shop/shop/order/{{$order->order_id}}" class="btn btn-sm"><i class="fa fa-rocket"></i></a>

                                            </td>
                                        </tr>
                                    @endforeach

                                    @foreach ($old_orders  as $order)
                                        <tr>
                                            <td class="bolder">

                                                @if(Auth::user()->role === 'admin')
                                                    <a style="color: #388e3c;" href="http://mmmethod.net/shop/ad/shop/order/{{$order->order_id}}">#{{$order->order_id}}
                                                        @if($order->coupon)
                                                            <small style="text-transform: uppercase;"> - {{$order->coupon}}</small>
                                                        @endif
                                                    </a>
                                                @else
                                                    <a style="color: #388e3c;" href="http://mmmethod.net/shop/shop/order/{{$order->order_id}}">#{{$order->order_id}}
                                                        @if($order->coupon)
                                                            <small style="text-transform: uppercase;"> - {{$order->coupon}}</small>
                                                        @endif
                                                    </a>
                                                @endif


                                            </td>
                                            <td>{{$order->order_total + $order->delivery_charge - $order->coupon_discount_amount}}</td>
                                            <td>{{$order->name}} - <small>{{$order->phone}}</small></td>

                                            <td>
                                                @if($order->created_at)
                                                    {{ date('M d h:i a', strtotime($order->created_at)) }}
                                                @endif
                                            </td>
                                            <td>
                                                {{--                                          @if($order->delivered_date)--}}
                                                {{--                                             {{ date('M d h:i a', strtotime($order->delivered_date)) }}--}}
                                                {{--                                           @endif--}}
                                                @if($order->c_order_received)
                                                    {{ date('M d h:i a', strtotime($order->c_order_received)) }}
                                                @endif
                                            </td>
                                            <td class="text-center" style="font-size: 12px;">
                                                @if($order->active_status==0)
                                                    <span style="blue">  Pending</span>
                                                @elseif($order->active_status==1)
                                                    <span style="background:#fff9c4;color: #fbc02d;padding: 3px 6px;border: 1px solid #8080801c;border-radius: 2px;"> Approved</span>
                                                @elseif($order->active_status==2)
                                                    <span style="background:#efebe9;color: #6d4c41;padding: 3px 6px;border: 1px solid #8080801c;border-radius: 2px;"> In Transit</span>
                                                @elseif($order->active_status==3)
                                                    <span style="color: #388e3c;background: #c8e6c9;padding: 3px 6px;border-radius: 2px;
border: 1px solid #81c784;"> Delivered</span>
                                                @elseif($order->active_status==4)
                                                    <span style="background:#feedef;color: #ef2f45;padding: 3px 6px;border: 1px solid #ef9a9a;border-radius: 2px;"> Cancel</span>
                                                @endif
                                            </td>
                                            <td class="text-center  ">
                                                @if(Auth::user()->role === 'admin')
                                                    <a style="color: rgb(56, 142, 60);
background: rgb(200, 230, 201) none repeat scroll 0% 0%;
padding: 3px 6px;
border-radius: 2px;
border: 1px solid rgb(129, 199, 132);" title="Order Details" target="_blank" href="http://mmmethod.net/shop/ad/shop/order/{{$order->order_id}}" class="btn btn-sm"><i class="fa fa-rocket"></i></a>

                                                @else
                                                    <a style="color: rgb(56, 142, 60);
background: rgb(200, 230, 201) none repeat scroll 0% 0%;
padding: 3px 6px;
border-radius: 2px;
border: 1px solid rgb(129, 199, 132);" title="Order Details" target="_blank" href="http://mmmethod.net/shop/order/{{$order->order_id}}" class="btn btn-sm"><i class="fa fa-rocket"></i></a>

                                                @endif

                                            </td>
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