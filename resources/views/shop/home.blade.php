@extends('layouts.app') @section('content')

        @include('layouts.shop-sidebar')

<div class="content-area">

    <div class="container-fluid mt30">
        <div class="row justify-content-center">
            <div style="width: 400px;display: none;">
                <canvas id="MeSeStatusCanvas">
                </canvas>
            </div>
            @if(Auth::user()->role=='shop')

                @if(count($check_if_not_price_add) > 0)
                    <div class="col-md-12">
                        <div class="alert alert-info fade in alert-dismissible"
                             style="padding: 8px 30px 8px 15px;margin-bottom: 0;">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close"><i
                                        style="font-size: 15px;" class="fa fa-close"></i></a>
                            <strong><i class="fa fa-info"></i></strong> Please add Missing Buy Price, ORDER ID:
                            <b> @foreach($check_if_not_price_add as $missing)
                                    <a target="_blank" href="https://gopalganjbazar.com/web/shop/order/{{$missing->pending_id}}">{{$missing->pending_id}}</a> ,
                                @endforeach</b>
                        </div>
                    </div>
                @endif
                <div class="col-md-6 ">
                    <p style="margin-top: 10px;color: #7cb342;font-size: 15px;font-weight: 700;">SALES REPORT DASHBOARD
                        <span class="pull-right">T.ORDERS: {{$total_orders}}</span></p>
                </div>

                <div class="clearfix"></div>
                <div class="col-md-6">
                    <div class="panel" style="margin-bottom:   5px;">
                        <div class="panel-body" style="padding:  7px 15px !important;">
                            <div style="color: #7cb342;
text-transform: uppercase;font-weight: 600;font-size: 13px; ">
                                Stock Money: <b class="pull-right"
                                                style="color: #ff8f00;font-size: 15px;">&#2547;
                                    {{ number_format($remaining_stock_amount->total_avaiable_stock_amount) }}
                                </b>
                            </div>
                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="pull-left">
                                        <div id="canvas-holder" style="margin-left: -70px;">
                                            <canvas id="chart-area"/>
                                        </div>

                                        <div id="chartjs-tooltip"></div>

                                    </div>
                                    <div>
                                        <ul class="graph-iabel">
                                            <li><i class="fa fa-circle" style="color: #00897b;"></i> TOTAL SALES
                                            </li>
                                            <li><i class="fa fa-circle" style="color: #ff8f00;"></i> BUY</li>
                                            <li><i class="fa fa-circle" style="color: #7cb342;"></i> PROFIT</li>
                                        </ul>


                                    </div>


                                </div>


                            </div>


                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel" style="margin-bottom:   5px;">
                        <div class="panel-body" style="padding: 1px !important;">
                            <div class="input-group input-daterange report_date_range">
                                <input type="text" class="form-control start" placeholder="From  YY-MM-DD">
                                <div class="input-group-addon">to</div>
                                <input type="text" class="form-control end" placeholder="To  YY-MM-DD">
                            </div>


                        </div>
                    </div>
                    <div class="panel summary-report report">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <span> </span> <span class="  text-right date-show"><i
                                                class="fa fa-calendar-check-o" aria-hidden="true"></i>  <span>
{{--                                            {{ date('M d', strtotime($sales_start_date->sales_start_date)) }}   -   {{ date('M d') }}--}}
                                        </span> Today Sales</span>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                            <tr>
                                                <td rowspan="3" class="leftrow">
                                                    Total Sales <br/>
                                                    <span class="s_amount">  <span class="tk">&#2547;</span> <span
                                                                class="amount_tk">{{ number_format($today_sales_summary->order_total + $today_sales_summary->delivery_charge - $today_sales_summary->coupon_discount_amount)}}</span></span>
                                                </td>

                                            </tr>

                                            <tr>
                                                <td class="btmborder">
                                                    Profit <br/> <span class="p_amount">  <span
                                                                class="tk">&#2547;</span>  {{ number_format($today_sales_summary->order_total + $today_sales_summary->delivery_charge - $today_sales_summary->coupon_discount_amount - $today_buy_amount->today_buy_amount ) }}</span>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td>
                                                    Buy <br/> <span class="b_amount">  <span
                                                                class="tk">&#2547;</span>  {{ number_format($today_buy_amount->today_buy_amount) }}</span>

                                                </td>

                                            </tr>

                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>

                </div>
            <div class="clearfix"></div>
            <div class="col-md-6">
                <div class="panel summary-report summary">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table stocklising">
                                        <tbody>
                                        <tr>
                                            <td class="comment" colspan="2">
                                                SHOP ACCOUNT SUMMARY
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="comment">
                                                GIVEN STOCK MONEY
                                            </td>
                                            <td class="dt taken" style="color: #7cb342;font-size: 16px;">
                                                &#2547;{{number_format($shop_given_stock_money - $shop_taken_stock_money)}} </td>
                                        </tr>
                                        <tr>
                                            <td class="comment">
                                                PRODUCT STOCK MONEY
                                            </td>
                                            <td class="dt taken" style="color: #7cb342;font-size: 16px;">
                                                &#2547;{{number_format($shop_total_avaiable_stock_amount)}} </td>
                                        </tr>
                                        <tr>
                                            <td class="comment">
                                                SHOP EXPENSE
                                            </td>
                                            <td class="dt taken" style="color: #7cb342;font-size: 16px;">
                                                &#2547;{{number_format($shop_expenses)}} </td>
                                        </tr>

                                        <tr>
                                            <td class="comment">
                                                EXPECTED MONEY: PROFIT + CASH
                                            </td>
                                            <td class="dt taken" style="color: #ff8f00;font-size: 16px;">
                                                &#2547;{{number_format($shop_given_stock_money - $shop_expenses - $shop_total_avaiable_stock_amount + $shop_total_profit - $shop_incomplete_order_total_buy_price)  }} </td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-md-6">
                <div class="panel summary-report report">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">

                                <div class="panel summary-report">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                    <span class="  text-right date-show"><i class="fa fa-calendar-check-o"
                                                                            aria-hidden="true"></i>  <span>Total </span>  Sales</span>
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <tbody>
                                                        <tr>
                                                            <td rowspan="3" class="leftrow">
                                                                Total Sales <br/>
                                                                <span class="s_amount">  <span class="tk">&#2547;</span> <span
                                                                            class="amount_tk">{{ number_format($sales_summary->order_total + $sales_summary->delivery_charge - $sales_summary->coupon_discount_amount)}}</span></span>
                                                            </td>

                                                        </tr>

                                                        <tr>
                                                            <td class="btmborder">
                                                                Profit <br/> <span class="p_amount">  <span
                                                                            class="tk">&#2547;</span>  {{ $sales_summary->order_total + $sales_summary->delivery_charge - $sales_summary->coupon_discount_amount - $total_buy_amount->total_buy_price }}</span>
                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Buy <br/> <span class="b_amount">  <span class="tk">&#2547;</span>  {{  $total_buy_amount->total_buy_price  }}</span>

                                                            </td>

                                                        </tr>

                                                        </tbody>
                                                    </table>
                                                </div>


                                            </div>


                                        </div>


                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
<span class="clearfix"></span>
            <div class="col-md-6">
                <div class="panel summary-report summary">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table stocklising">

                                        <thead>
                                        <tr>
                                            <th style="border: none" colspan="5">Product Expires In 30 Days <a href="/web/shop/expire-products" target="_blank">Expired List</a></th>
                                        </tr>
                                        <tr>
                                            <td class="comment">
                                                Name
                                            </td>
                                            {{--                                                    <td class="comment">--}}
                                                {{--                                                        Quantity--}}
                                                {{--                                                    </td>--}}

                                            <td class="comment">
                                                Date
                                            </td>

                                        </tr>
                                        </thead>
                                        <tbody id="expire_list">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

{{--                <div class="col-md-6">--}}
{{--                    <div class="panel summary-report">--}}
{{--                        <div class="panel-body">--}}
{{--                            <div class="row">--}}
{{--                                <div class="col-md-12">--}}

{{--                                    <div class="table-responsive">--}}
{{--                                        <table class="table">--}}
{{--                                            <tbody>--}}
{{--                                            <tr>--}}
{{--                                                <td rowspan="3" class="leftrow">--}}
{{--                                                    Stock Money <br>--}}
{{--                                                    <span class="s_amount">  <span class="tk">&#2547;</span> <span--}}
{{--                                                                class="amount_tk"> 00</span></span>--}}
{{--                                                </td>--}}

{{--                                            </tr>--}}

{{--                                            <tr>--}}
{{--                                                <td class="btmborder">--}}
{{--                                                    GIVEN FOR Stock <br> <span class="p_amount">  <span--}}
{{--                                                                class="tk">&#2547;</span>   0 </span>--}}
{{--                                                </td>--}}

{{--                                            </tr>--}}
{{--                                            <tr>--}}
{{--                                                <td>--}}
{{--                                                    Taken from Stock <br> <span class="b_amount">  <span--}}
{{--                                                                class="tk">&#2547;</span> 0 </span>--}}

{{--                                                </td>--}}

{{--                                            </tr>--}}

{{--                                            </tbody>--}}
{{--                                        </table>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-md-6">--}}
{{--                    <div class="panel summary-report summary" >--}}
{{--                        <div class="panel-body" style="height: 162px;--}}
{{--overflow-y: scroll;--}}
{{--scrollbar-width: none;">--}}
{{--                            <div class="row">--}}
{{--                                <div class="col-md-12">--}}
{{--                                    <div class="table-responsive">--}}
{{--                                        <table class="table stocklising">--}}
{{--                                            <tbody>--}}
{{--                                            @foreach($stock_summary as $summary)--}}
{{--                                                <tr>--}}
{{--                                                    <td @if($summary->type =="money-plus")  class="dt given"--}}
{{--                                                        @else  class="dt taken" @endif>--}}
{{--                                                        &#2547;{{$summary->amount}} </td>--}}
{{--                                                                                                        <td class="comment" title="{{$summary->purpose}}">--}}
{{--                                                                                                            @if($summary->type =="money-plus")--}}
{{--                                                                                                                Money Plus--}}
{{--                                                                                                            @else--}}
{{--                                                                                                                Money Minus--}}
{{--                                                                                                            @endif--}}
{{--                                                                                                        </td>--}}
{{--                                                    <td>{{ str_limit($summary->purpose, $limit = 50, $end = '...') }}</td>--}}
{{--                                                                                                        <td class=" text-right" title="Created Date">--}}
{{--                                                                                                            <small>{{  date('M d', strtotime($summary->created_at)) }} </small>--}}
{{--                                                                                                        </td>--}}
{{--                                                    <td class=" text-right" title="Date For">--}}
{{--                                                        <small>{{  date('M d', strtotime($summary->date)) }}</small>--}}
{{--                                                    </td>--}}
{{--                                                    <td class="text-center"> <i title="ADDED BY {{$summary->name}}" class="fa fa-info-circle"></i></td>--}}
{{--                                                </tr>--}}
{{--                                            @endforeach--}}

{{--                                            </tbody>--}}
{{--                                        </table>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="col-md-6">--}}
{{--                    <div class="panel summary-report summary">--}}
{{--                        <div class="panel-body">--}}
{{--                            <div class="row">--}}
{{--                                <div class="col-md-12">--}}
{{--                                    <div class="table-responsive">--}}
{{--                                        <table class="table stocklising">--}}
{{--                                            <tbody>--}}
{{--                                            <tr>--}}
{{--                                                <td class="comment" colspan="2">--}}
{{--                                                    ACCOUNT SUMMARY--}}
{{--                                                </td>--}}
{{--                                            </tr>--}}
{{--                                            <tr>--}}
{{--                                                <td class="comment">--}}
{{--                                                    DUE AMOUNT--}}
{{--                                                </td>--}}
{{--                                                <td class="dt taken" style="color: #7cb342;font-size: 16px;">--}}
{{--                                                    &#2547;{{ number_format($total_due_amount->amount - $total_due_paid->pay_amount) }}--}}
{{--                                                </td>--}}
{{--                                            </tr>--}}
{{--                                            <tr>--}}
{{--                                                <td class="comment">--}}
{{--                                                    WAITING STOCK MONEY--}}
{{--                                                </td>--}}
{{--                                                <td class="dt taken" style="color: #7cb342;font-size: 16px;">--}}
{{--                                                    &#2547;{{ number_format($waiting_stock_money->total_price) }}--}}
{{--                                                </td>--}}
{{--                                            </tr>--}}
{{--                                            <tr>--}}
{{--                                                <td class="comment">--}}
{{--                                                    INCOMPLETE ORDER AMOUNT--}}
{{--                                                </td>--}}
{{--                                                <td class="dt taken" style="color: #7cb342;font-size: 16px;">--}}
{{--                                                    &#2547;{{ number_format($incomplete_order_buy_price) }} </td>--}}
{{--                                            </tr>--}}
{{--                                            <tr>--}}
{{--                                                <td class="comment">--}}
{{--                                                    DEPOSIT MONEY--}}
{{--                                                </td>--}}
{{--                                                <td class="dt taken" style="color: #7cb342;font-size: 16px;">--}}
{{--                                                    &#2547;{{ $remaining_deposit_money }} --}}
{{--                                                </td>--}}
{{--                                            </tr>--}}
{{--                                            <tr>--}}
{{--                                                <td class="comment">--}}
{{--                                                    EXPECTED CASH--}}
{{--                                                </td>--}}
{{--                                                <td class="dt taken" style="color: #ff8f00;font-size: 16px;">--}}
{{--                                                    &#2547; {{ ( $remaining_stock_amount->total_avaiable_stock_amount + $incomplete_order_buy_price )    }} </td>--}}
{{--                                            </tr>--}}







{{--                                            </tbody>--}}
{{--                                        </table>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-md-6">--}}
{{--                    <div class="panel summary-report summary">--}}
{{--                        <div class="panel-body" style="height: 277px;--}}
{{--overflow-y: scroll;--}}
{{--scrollbar-width: none;">--}}
{{--                            <div class="row">--}}
{{--                                <div class="col-md-12">--}}
{{--                                    <div class="table-responsive">--}}
{{--                                        <table class="table stocklising">--}}

{{--                                            <tbody>--}}
{{--                                            <tr>--}}
{{--                                                <td class="dt  " colspan="4">--}}
{{--                                                    <span style="font-size: 12px;font-weight: normal;text-transform: uppercase;">Daily Update Summary</span>--}}
{{--                                                </td>--}}
{{--                                            </tr>--}}
{{--                                            <tr>--}}
{{--                                                <td class="dt"  >--}}
{{--                                                    <span style="font-size: 12px;font-weight: normal;text-transform: uppercase;">Hand Cash</span>--}}
{{--                                                </td>--}}
{{--                                                <td class="dt" colspan="3" >--}}
{{--                                                    <span style="font-size: 12px;font-weight: normal;text-transform: uppercase;">Day end Summary Cash</span>--}}
{{--                                                </td>--}}

{{--                                            </tr>--}}

{{--                                            </tbody>--}}
{{--                                        </table>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                                <div class="col-md-12">--}}
{{--                                    <div class="panel">--}}
{{--                                        <div class="panel-body">--}}
{{--                                            <canvas id="myChart">--}}
{{--                                            </canvas>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                <div class="clearfix"></div>--}}
{{--                <div class="col-md-6">--}}
{{--                    <div class="panel summary-report summary">--}}
{{--                        <div class="panel-body">--}}
{{--                            <div class="row">--}}
{{--                                <div class="col-md-12">--}}
{{--                                    <div class="table-responsive">--}}
{{--                                        <table class="table stocklising">--}}

{{--                                            <thead>--}}
{{--                                            <tr>--}}
{{--                                                <th style="border: none" colspan="5">Product Expires In 15 Days--}}
{{--                                                    <a href="/web/ad/expire-products" target="_blank">Expired List</a>--}}
{{--                                                </th>--}}
{{--                                            </tr>--}}
{{--                                            <tr>--}}
{{--                                                <td class="comment">--}}
{{--                                                    Name--}}
{{--                                                </td>--}}
{{--                                                                                                    <td class="comment">--}}
{{--                                                                                                        Quantity--}}
{{--                                                                                                    </td>--}}

{{--                                                <td class="comment">--}}
{{--                                                    Date--}}
{{--                                                </td>--}}

{{--                                            </tr>--}}
{{--                                            </thead>--}}
{{--                                            <tbody id="expire_list">--}}

{{--                                            </tbody>--}}
{{--                                        </table>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
                 <div class="col-md-6">
                     <div class="panel summary-report summary">
                         <div class="panel-body">
                             <div class="row">
                                 <div class="col-md-12">
                                     <div class="table-responsive">
                                         <table class="table stocklising">
                                             <tbody>
                                             <tr>
                                                 <th style="border: none" colspan="5">Today added products in real stock</th>
                                             </tr>
                                             <tr>
                                                 <td class="comment">
                                                     Name
                                                 </td>
                                                 <td class="comment">
                                                     Quantity
                                                 </td>

                                                 <td class="comment">
                                                     Buy Price
                                                 </td>

                                             </tr>
                                             @foreach($today_added_products_in_stock as $today_added)
                                             <tr>
                                                 <td class=" taken" style="color: #000;font-size: 14px;">

                                                     @foreach($allproducts as $product)

                                                     @if( $product->id === $today_added->product_id)
                                                     {{$product->name}}      {{$product->unit_quantity}} {{$product->unit}}
                                                     @endif
                                                     @endforeach

                                                 </td>
                                                 <td class=" taken" style="color: #7cb342;font-size: 14px;">
                                                     {{$today_added->quantity}}
                                                 </td>
                                                 <td class=" taken" style="color: #7cb342;font-size: 14px;">
                                                     {{$today_added->price}}
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
{{--                                    <div class="col-md-6">--}}
{{--                                        <div class="panel summary-report summary">--}}
{{--                                            <div class="panel-body">--}}
{{--                                                <div class="row">--}}
{{--                                                    <div class="col-md-12">--}}
{{--                                                        <div class="table-responsive">--}}
{{--                                                            <table class="table stocklising">--}}
{{--                                                                <tbody>--}}
{{--                                                                @if($today_expense)--}}
{{--                                                                @foreach($today_expense as $expense)--}}
{{--                                                                    <tr>--}}
{{--                                                                        <td class="dt given">--}}
{{--                                                                            &#2547; {{$expense->amount}} </td>--}}
{{--                                                                        <td class="comment">--}}
{{--                                                                            {{$expense->purpose}}--}}
{{--                                                                        </td>--}}
{{--                                                                        <td class=" text-right" title="Created Date">--}}
{{--                                                                            <small>{{  date('M d', strtotime($expense->created_at)) }} </small>--}}
{{--                                                                        </td>--}}
{{--                                                                        <td class="text-center"> <i title="ADDED BY {{$expense->name}}" class="fa fa-info-circle"></i></td>--}}
{{--                                                                    </tr>--}}
{{--                                                                @endforeach--}}
{{--                                                                @endif--}}
{{--                                                                </tbody>--}}
{{--                                                            </table>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                <style>
                    .summary-report.summary {
                        min-height: 165px;

                    }

                    .summary-report table.stocklising {
                        margin-bottom: 0;
                    }

                    .table.stocklising tr td {
                        font-size: 14px;
                        padding: 5px !important;
                        border: 1px solid #e8e8e891 !important;
                        text-transform: capitalize;
                    }

                    .stocklising .dt {
                        font-weight: bold;
                        font-size: 16px;
                    }

                    .given {
                        color: #7cb342;
                    }

                    .taken {
                        color: #ff8f00;
                    }

                    .table.stocklising tr td.comment {
                        font-size: 12px;
                    }
                </style>
{{--                <div class="col-md-12">--}}
{{--                    <div class="panel">--}}
{{--                        <div class="panel-body">--}}
{{--                            <canvas id="myChart">--}}
{{--                            </canvas>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

            @elseif(Auth::user()->role=='manager')


                <div class="col-md-12">
                    <p style="margin-top: 10px;color: #7cb342;font-size: 15px;font-weight: 700;">SALES REPORT
                        DASHBOARD </p>
                </div>
                <div class="col-md-6">
                    <div class="panel" style="margin-bottom:   5px;">
                        <div class="panel-body" style="padding:  7px 15px !important;">
                            <div style="color: #7cb342;
text-transform: uppercase;font-weight: 600;font-size: 13px; ">
                                Stock Money: <b class="pull-right"
                                                style="color: #ff8f00;font-size: 15px;">&#2547;{{ number_format($remaining_stock_amount->total_avaiable_stock_amount) }}</b>
                            </div>
                        </div>
                    </div>
                    <div class="panel">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="pull-left">
                                        <div id="canvas-holder" style="margin-left: -70px;">
                                            <canvas id="chart-area"/>
                                        </div>

                                        <div id="chartjs-tooltip"></div>

                                    </div>
                                    <div>
                                        <ul class="graph-iabel">
                                            <li><i class="fa fa-circle" style="color: #00897b;"></i> TOTAL SALES</li>
                                            <li><i class="fa fa-circle" style="color: #ff8f00;"></i> BUY</li>
                                            <li><i class="fa fa-circle" style="color: #7cb342;"></i> PROFIT</li>
                                        </ul>


                                    </div>


                                </div>


                            </div>


                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div style="height: 42px;"><span class="pull-right"
                                                     style="color: #7cb342;font-size: 15px;font-weight: 700;">TODAY ORDERS: {{$total_orders}}</span>
                    </div>
                    <div class="panel summary-report">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <span class="  text-right date-show"><i class="fa fa-calendar-check-o"
                                                                            aria-hidden="true"></i>  <span>Today </span>  Sales</span>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                            <tr>
                                                <td rowspan="3" class="leftrow">
                                                    Total Sales <br/>
                                                    <span class="s_amount">  <span class="tk">&#2547;</span> <span
                                                                class="amount_tk">{{ number_format($sales_summary->order_total + $sales_summary->delivery_charge - $sales_summary->coupon_discount_amount)}}</span></span>
                                                </td>

                                            </tr>

                                            <tr>
                                                <td class="btmborder">
                                                    Profit <br/> <span class="p_amount">  <span
                                                                class="tk">&#2547;</span>  {{ $sales_summary->order_total + $sales_summary->delivery_charge - $sales_summary->coupon_discount_amount - $total_buy_amount->total_buy_price }}</span>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td>
                                                    Buy <br/> <span class="b_amount">  <span class="tk">&#2547;</span>  {{  $total_buy_amount->total_buy_price  }}</span>

                                                </td>

                                            </tr>

                                            </tbody>
                                        </table>
                                    </div>


                                </div>


                            </div>


                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-6">
                    <div class="panel summary-report">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                            <tr>
                                                <td rowspan="3" class="leftrow">
                                                    Stock Money <br>
                                                    <span class="s_amount">  <span class="tk">৳</span> <span
                                                                class="amount_tk">{{ $plus_for_stock_amount - $minus_from_stock_amount  }}</span></span>
                                                </td>

                                            </tr>

                                            <tr>
                                                <td class="btmborder">
                                                    GIVEN FOR Stock <br> <span class="p_amount">  <span
                                                                class="tk">৳</span>   {{$plus_for_stock_amount}} </span>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td>
                                                    Taken from Stock <br> <span class="b_amount">  <span
                                                                class="tk">৳</span> {{$minus_from_stock_amount}} </span>

                                                </td>

                                            </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="panel summary-report summary">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table stocklising">
                                            <tbody>





                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-12">
                    <div class="panel summary-report summary">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table stocklising">
                                            <tbody>
                                            <tr>
                                                <th colspan="5">Daily Update Summary</th>
                                            </tr>
                                            <tr>
                                                <td class="comment">
                                                    Real Stock
                                                </td>
                                                <td class="comment">
                                                    product_stock_amount
                                                </td>

                                                <td class="comment">
                                                    Due Amount
                                                </td>
                                                <td class="comment">
                                                    Waiting Stock Amount
                                                </td>
                                                <td class="comment">
                                                    Incomplete Order Amount
                                                </td>

                                                <td class="comment">
                                                    Hand Cash
                                                </td>
                                                <td class="comment">
                                                    Summary
                                                </td>
                                            </tr>
                                            @foreach($daily_summary as $daily)
                                                <tr>
                                                    <td class="dt taken" style="color: #7cb342;font-size: 16px;">
                                                        &#2547;  {{$daily->real_stock_amount}}</td>
                                                    <td class="dt taken" style="color: #7cb342;font-size: 16px;">
                                                        &#2547;  {{$daily->product_stock_amount}}</td>

                                                    <td class="dt taken" style="color: #7cb342;font-size: 16px;">
{{--                                                        &#2547;  {{$daily->due_amount}}--}}
                                                    </td>

                                                    <td class="dt taken" style="color: #7cb342;font-size: 16px;">
{{--                                                        &#2547;  {{$daily->waiting_stock_money}}--}}
                                                    </td>
                                                    <td class="dt taken" style="color: #7cb342;font-size: 16px;">
                                                        &#2547; {{$daily->incomplete_order_amount}} </td>
                                                    <td class="dt taken" style="color: #7cb342;font-size: 16px;">
                                                        &#2547;  {{$daily->hand_cash}}</td>
                                                    <td class="dt taken" style="color: #7cb342;font-size: 16px;">
                                                        &#2547;  {{$daily->summary}}</td>

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
                <div class="col-md-12">
                    <div class="panel summary-report summary">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table stocklising">
                                            <tbody>
                                            <tr>
                                                <th colspan="5">Today added products in real stock</th>
                                            </tr>
                                            <tr>
                                                <td class="comment">
                                                    Name
                                                </td>
                                                <td class="comment">
                                                    Quantity
                                                </td>

                                                <td class="comment">
                                                    Buy Price
                                                </td>

                                            </tr>
                                            @foreach($today_added_products_in_stock as $today_added)
                                                <tr>
                                                    <td class=" taken" style="color: #7cb342;font-size: 14px;">

                                                        @foreach($allproducts as $product)

                                                            @if( $product->id === $today_added->product_id)
                                                                {{$product->name}}      {{$product->unit_quantity}} {{$product->unit}}
                                                            @endif
                                                        @endforeach

                                                    </td>
                                                    <td class=" taken" style="color: #7cb342;font-size: 14px;">
                                                        {{$today_added->quantity}}
                                                    </td>
                                                    <td class=" taken" style="color: #7cb342;font-size: 14px;">
                                                        {{$today_added->price}}
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

            @else
            @endif
        </div>
    </div>
</div>



<script>
    function daysInMonth(month, year) {
        return new Date(year, month, 0).getDate();
    }

    var year = moment().format('YYYY')
    var month = moment().format('M')
    //console.log(daysInMonth(month,year));
    //var totalDays=daysInMonth(month,year);
    var totalDays = daysInMonth(month, year);
    var arr = [];

    for (var i = 1; i < totalDays + 1; i++) {
        arr.push(i);
    }
    console.log(arr.to);
    var canvas = document.getElementById('myChart');
    var data = {
        labels: [
            @foreach ($sales as $sale)
            {{ date('d', strtotime($sale->date))}},
            @endforeach
        ],
        datasets: [
            {
                label: "Daily Sales Report",
                backgroundColor: "rgba(255,99,132,0.2)",
                borderColor: "rgba(255,99,132,1)",
                borderWidth: 1,
                hoverBackgroundColor: "rgba(255,99,132,0.4)",
                hoverBorderColor: "rgba(255,99,132,1)",
                data: [
{{--                    @foreach ($sales as $sale)--}}
{{--                    {{ $sale->order_total+$sale->delivery_charge-$sale->coupon_discount_amount}},--}}
{{--                    @endforeach--}}
                ],
            }
        ]
    };
    var option = {
        animation: {
            duration: 5000
        }

    };


    var myBarChart = Chart.Bar(canvas, {
        data: data,
        options: option
    });


    window.chartColors = {

        purple: '#00897b',
        orange: '#ff8f00',
        green: '#7cb342'
        //red: 'rgb(255, 99, 132)',
        //yellow: 'rgb(255, 205, 86)',
        //blue: 'rgb(54, 162, 235)',
        //grey: 'rgb(231,233,237)'
    };

    Chart.defaults.global.tooltips.custom = function (tooltip) {
        // Tooltip Element
        var tooltipEl = document.getElementById('chartjs-tooltip');

        // Hide if no tooltip
        if (tooltip.opacity === 0) {
            tooltipEl.style.opacity = 0;
            return;
        }

        // Set Text
        if (tooltip.body) {
            var total = 0;

            // get the value of the datapoint
            var value = this._data.datasets[tooltip.dataPoints[0].datasetIndex].data[tooltip.dataPoints[0].index].toLocaleString();

            // calculate value of all datapoints
            this._data.datasets[tooltip.dataPoints[0].datasetIndex].data.forEach(function (e) {
                total += e;
            });

            // calculate percentage and set tooltip value
            tooltipEl.innerHTML = '<h1>' + (value / total * 100) + '%</h1>';
        }

        // calculate position of tooltip
        var centerX = (this._chartInstance.chartArea.left + this._chartInstance.chartArea.right) / 2;
        var centerY = ((this._chartInstance.chartArea.top + this._chartInstance.chartArea.bottom) / 2);

        // Display, position, and set styles for font
        tooltipEl.style.opacity = 1;
        tooltipEl.style.left = centerX + 'px';
        tooltipEl.style.top = centerY + 'px';
        tooltipEl.style.fontFamily = tooltip._fontFamily;
        tooltipEl.style.fontSize = tooltip.fontSize;
        tooltipEl.style.fontStyle = tooltip._fontStyle;
        tooltipEl.style.padding = tooltip.yPadding + 'px ' + tooltip.xPadding + 'px';
    };

    var config = {
        type: 'doughnut',
        data: {
            datasets: [{
                data: [{{$sales_summary->order_total + $sales_summary->delivery_charge - $sales_summary->coupon_discount_amount}}, {{$total_buy_amount->total_buy_price}}, {{$sales_summary->order_total + $sales_summary->delivery_charge - $sales_summary->coupon_discount_amount - $total_buy_amount->total_buy_price}}],
                backgroundColor: [
                    window.chartColors.purple,
                    window.chartColors.orange,
                    window.chartColors.green
                ],
            }],
            labels: [
                "TOTAL SALES",
                "BUY",
                "PROFIT"
            ]
        },
        options: {
            responsive: true,
            legend: {
                display: false,
            },
            tooltips: {
                enabled: true,
            }
        }
    };

    window.onload = function () {
        var ctx = document.getElementById("chart-area").getContext("2d");
        window.myPie = new Chart(ctx, config);
    };


</script>
{{--@if($check_new_order>0)--}}
{{--    <script>--}}

{{--        window.onload = function loadFrame() {--}}
{{--            document.getElementById("my_audio").play();--}}
{{--        };--}}
{{--    </script>--}}
{{--@endif--}}
@section('footerjs')

    <script>

        jQuery(".report_date_range input").val('');

        jQuery('.input-daterange input').each(function () {
            jQuery(this).datepicker({
                clearDates: true,
                format: 'yyyy-mm-dd',
                todayHighlight: true,
                autoclose: true
            });
        });

        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        jQuery.ajax({
            type: 'GET',
            url: '/web/api/product-expires-list',
            dataType: "json",
            data: '_token = <?php echo csrf_token() ?>',
            success: function (data) {

                var table = jQuery("#expire_list");
                console.log(data);
                jQuery.each(data.data, function (key, value) {
                    if(value.product_remaining_quantity > 0){
                        // alert(value.name);
                        table.append("<tr>" +
                            "<td><a style='color: #000;' target='_blank' href="+'ad/products/'+value.product_id+">" + value.name + ' '+  value.unit_quantity + ' '+ value.unit +"</a></td>" +
                            // "<td>" + value.quantity + "</td>" +
                            "<td>" + value.expire_date + "</td>");
                    }
                });

                //console.log(data);


            }
        });

        jQuery(document).on('change', '.report_date_range input', function () {
            var startDate = jQuery("input.start").val();
            var endDate = jQuery("input.end").val();

            if (startDate != '' && endDate != '') {
                jQuery.ajax({
                    type: 'GET',
                    url: '/web/shop/sales-calculation/' + startDate + '/' + endDate,
                    dataType: "json",
                    data: '_token = <?php echo csrf_token() ?>',
                    success: function (data) {
                        console.log(data);

                        var finalStartDate = moment(startDate).format('MMM Do ');
                        var finalEndDate = moment(endDate).format('MMM Do ');
                        jQuery(".date-show span").text(finalStartDate + " - " + finalEndDate);
                        var finalVal = parseInt(data.sales_data.order_total) + parseInt(data.sales_data.delivery_charge) - parseInt(data.sales_data.coupon_discount_amount);
                        console.log(data);
                        jQuery(".report .s_amount .amount_tk").text(finalVal.toLocaleString());
                        jQuery(".report .p_amount").text((finalVal - data.buy_amount.total_buy_price).toLocaleString());
                        jQuery(".report .b_amount").text(data.buy_amount.total_buy_price.toLocaleString());

                        Command: toastr["info"]("Request Completed Successfully");
                    }
                });
            }
        });
    </script>


@endsection

@endsection