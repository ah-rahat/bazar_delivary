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
                        <div class="panel-heading"> Marketers Order Used Coupon Lists</div>
                        <div class="panel-body">
                            <div class="table-responsive">
                            <table id="example" class="table table-striped " style="font-size: 14px;">
                                <thead>
                                <tr class="text-uppercase">
                                    <td style="font-size: 13px;">#order id</td>
                                     <td style="font-size: 13px;"> Used Coupon </td>
                                    <td style="font-size: 13px;">Amount</td> 
                                    <td style="font-size: 13px;"> D.Date  </td>
                                    <td  style="font-size: 13px;" class="text-center">Status  </td>
                                    <td>     </td>
                                </tr>
                                </thead>
                                <tbody>

                                 @foreach ($orders  as $order)
                                     <tr>
                                         <td class="bolder"><a style="color: #388e3c;" href="order/{{$order->order_id}}">#{{$order->order_id}}
                                           
                                         </a></td>
                                         <td>
                                           @if($order->coupon)
                                         <small style="text-transform: uppercase;"> {{$order->coupon}}</small>
                                          @endif
                                         </td>
                                           <td>
                                          {{$order->order_total + $order->delivery_charge - $order->coupon_discount_amount}} TK
                                         </td>
                                         <td>
                                          @if($order->delivered_date)
                                             {{ date('M d h:i a', strtotime($order->delivered_date)) }}
                                           @else
                                           N/A
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
                                          <!--
                                          https://itsolutionstuff.com/post/laravel-5-confirmation-before-delete-record-from-database-exampleexample.html
                                        
      
<button type="button" class="btn btn-secondary" data-container="body" data-toggle="popover" data-placement="left" data-content="<button><button>">
  Popover on left
</button>  -->
                                         <a title="REMOVE COUPON" style="color: #ff8f00;
background: #ffecb3;
padding: 3px 6px;
border-radius: 2px;
border: 1px solid #ffb300;" title="Order Details" href="remove-used-coupon/{{$order->order_id}}" class="btn btn-sm"><i class="fa fa-trash"></i></a>
 
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