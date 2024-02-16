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
                        <div class="panel-heading">  Order Lists</div>
                        <div class="panel-body">
                            <table id="datatable" class="table table-striped ">
                                <thead>
                                <tr class="text-uppercase">
                                    <td>Product name</td>
                                    <td>Unit price</td>
                                    <td> Order Amount </td>
                                      <td> Total  </td>
                                    <td> Date  </td>
                                     <td> Status  </td>
                                     
                                </tr>
                                </thead>
                                <tbody>

                                 @foreach ($orders  as $order)
                                     <tr>
                                          
                                         <td>{{$order->name}}</td>
                                         <td>{{$order->unit_price}}</td>
                                          <td>{{$order->order_quantity}}</td>
                                           <td>{{$order->total_price}}</td>
                                             <td>
                                            {{ date('m d Y ', strtotime($order->order_date)) }} 
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
@endsection