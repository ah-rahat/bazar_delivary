@extends('layouts.app')
@section('content')
    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.21/dist/vue.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.12.0/underscore-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    @if(Auth::user()->role === 'admin')
        @include('layouts.admin-sidebar')
    @else
        @include('layouts.other-sidebar')
    @endif
    <div class="content-area" id="myapp">
        <div class="container-fluid mt30">
            <div class="row justify-content-center">
                <div class="col-md-12 mt30">
                    <div class="panel">
                        <div class="panel-heading">Orders List
                            <form  method="GET" action="{{url('')}}/ad/orders-light">
                                <input type="text" name="data" placeholder="Customer Name OR Number" class="form-control end"
                                       style="float: right; width: 335px;">
                            </form>
                          </div>
                        <div class="panel-body">
                            <div>
                                <table class="table table-striped ">
                                    <thead>
                                    <tr>

                                        <td>#order ID</td>
                                        <td>Amount</td>
                                        <td>customer</td>
                                        <td>O.Date</td>
                                        <td>C.R.Date</td>
                                        <td width="80px"></td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($orders  as $order)
                                        <tr>
                                            <td class="bolder">

                                                @if(Auth::user()->role === 'admin')
                                                    <a style="color: #388e3c;" href="{{URL::to('/')}}/ad/order/{{$order->order_id}}">#{{$order->order_id}}
                                                        @if($order->coupon)
                                                            <small style="text-transform: uppercase;"> - {{$order->coupon}}</small>
                                                        @endif
                                                    </a>
                                                @elseif(Auth::user()->role === 'manager')
                                                    <a style="color: #388e3c;" href="https://gopalganjbazar.com/web/pm/order/{{$order->order_id}}">#{{$order->order_id}}
                                                        @if($order->coupon)
                                                            <small style="text-transform: uppercase;"> - {{$order->coupon}}</small>
                                                        @endif
                                                    </a>
                                                @elseif(Auth::user()->role === 'author')
                                                    <a style="color: #388e3c;" href="https://gopalganjbazar.com/web/au/order/{{$order->order_id}}">#{{$order->order_id}}
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
border: 1px solid rgb(129, 199, 132);" title="Order Details" target="_blank" href="{{URL::to('/')}}/ad/order/{{$order->order_id}}" class="btn btn-sm"><i class="fa fa-rocket"></i></a>
                                                @elseif(Auth::user()->role === 'manager')
                                                    <a style="color: rgb(56, 142, 60);
background: rgb(200, 230, 201) none repeat scroll 0% 0%;
padding: 3px 6px;
border-radius: 2px;
border: 1px solid rgb(129, 199, 132);" title="Order Details" target="_blank" href="https://gopalganjbazar.com/web/pm/order/{{$order->order_id}}" class="btn btn-sm"><i class="fa fa-rocket"></i></a>
                                                @elseif(Auth::user()->role === 'author')
                                                    <a style="color: rgb(56, 142, 60);
background: rgb(200, 230, 201) none repeat scroll 0% 0%;
padding: 3px 6px;
border-radius: 2px;
border: 1px solid rgb(129, 199, 132);" title="Order Details" target="_blank" href="https://gopalganjbazar.com/web/au/order/{{$order->order_id}}" class="btn btn-sm"><i class="fa fa-rocket"></i></a>

                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                {{ $orders->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>

@endsection
