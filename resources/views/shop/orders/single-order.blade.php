@extends('layouts.app')
@section('content')
    @if(Auth::user()->role === 'admin')
        @include('layouts.admin-sidebar')
    @else
        @include('layouts.shop-sidebar')
    @endif


    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <div class="content-area">
        <div class="container-fluid mt30">
            <div class="row justify-content-center">
                <div class="col-md-12">

                    @if( $get_order_total->get_order_total != $order_custumer->order_total)
                        <div class="alert alert-danger" role="alert">
                            Order Amount Calculation ERROR!!!!
                        </div>
                    @endif
                    <div class="panel panel-default simple-panel">
                        <div class="panel-heading">
                            Order ID: <span class="orange-color">#{{ $order_custumer->order_id }}</span>
                            <span>
                              <small>PHONE: <span class="orange-color">{{ $order_custumer->phone }}</span></small>
{{--                               <small>TRN ID: <span class="orange-color">{{ $order_custumer->transaction_number }}</span></small>--}}
                           </span>
{{--                            <a href="print-en/{{$order_custumer->order_id}}/" target="_blank"--}}
{{--                               class="btn btn-primary btn-sm pull-right">PRINT EN</a>--}}
                            <a href="print/{{$order_custumer->order_id}}/" target="_blank"
                               class="btn btn-primary btn-sm pull-right mr15">PRINT BN</a>
                            <a href="custom-order/{{$order_custumer->order_id}}/" target="_blank"
                               class="btn btn-warning btn-sm pull-right mr15">CUSTOM ORDER</a>
{{--                            <a href="order_buy_price_print/{{$order_custumer->order_id}}/" target="_blank"--}}
{{--                               class="btn btn-default btn-sm pull-right mr15">ADMIN COPY</a>--}}

                            <button type="button" onclick="update_fields_show()"
                                    class="btn btn-default btn-sm pull-right mr15 show_pricing_field"><i
                                        class="fa fa-tag"></i></button>



                        </div>

                        <div class="panel-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif


                                {!! Form::open(['url' => 'shop/order/order_status','class'=>'form-vertical','enctype'=>'multipart/form-data','files'=>true ]) !!}



                            {{ csrf_field() }}
                            <input type="hidden" id="cus_phone" name="phone" value="{{$order_custumer->phone}}"/>
                            <input type="hidden" name="order_total"
                                   value="{{$order_custumer->order_total + $order_custumer->delivery_charge - $order_custumer->coupon_discount_amount}}"/>

                            <table class="table table-striped table-bordered edit_order_table">
                                <thead>
                                <tr>
                                    <td></td>
                                    <td>Product Name</td>
                                    <td class="text-center">Photo</td>
                                    <td class="text-center">Unit Price</td>
                                    <td class="text-center">Order.Qty</td>
                                    <td> Total</td>
                                    <td colspan="2" class="buy_price_th text-center"> Buy Price</td>

                                </tr>
                                </thead>
                                <tbody>

                                @foreach ($order_products  as $order_product)
                                    <tr id="product_{{$order_product->product_id}}">
                                        @if($order_custumer->active_status>=3)
                                            <td></td>
                                        @else
                                            @if(count($order_products) >1 )
                                            <td width="25px"
                                                onclick="openModal({{$order_custumer->order_id }},{{$order_product->product_id}},{{$order_product->quantity}})"
                                                class="text-center removeProduct"
                                                data-orderid="{{$order_custumer->order_id }}"
                                                data-productid="{{$order_product->product_id}}">
                                                 <img src="{{ url('/images/error.png') }}" width="25px"/>
                                            </td>
                                            @else
                                                <td></td>
                                            @endif

                                        @endif
                                        @foreach ($products  as $product)
                                            @if($order_product->product_id ==$product->id)
                                                <td>

                                                    @if($order_product->custom_name_en)
                                                        {{$order_product->custom_name_en}}
                                                        <input type="hidden" class="name_en"
                                                               value="{{$order_product->custom_name_en}}">
                                                        <input type="hidden" class="name_bn"
                                                               value="{{$order_product->custom_name_bn}}">

                                                    @else
                                                        <input type="hidden" class="name_en"
                                                               value="{{$product->name}} {{$product->strength}} {{$product->unit_quantity}} {{$product->unit}}">
                                                        <input type="hidden" class="name_bn"
                                                               value="{{$product->name_bn}} {{$product->strength}}  {{$product->unit_quantity}} {{$product->unit}}">
                                                        <div> {{$product->name}} {{$product->strength}}
                                                            {{$product->unit_quantity}} <span
                                                                    style="text-transform: capitalize;">{{$product->unit}}</span>
                                                        </div>

                                                    @endif
                                                    @foreach ($customize_products  as $customize_product)
                                                        @if($customize_product->product_id == $product->id)
                                                            @if($order_custumer->active_status<3)
                                                                <i class="fa fa-pencil"
                                                                   onclick="CustomProductModal({{$order_custumer->order_id }},{{$order_product->product_id}},{{$order_product->quantity}},{{$order_product->unit_price}},{{$order_product->total_price}})"></i>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td class="text-center">
                                                    <img width="55px"
                                                         src="{{ url('/uploads/products') }}/{{$product->featured_image}}"/>
                                                </td>
                                            @endif

                                        @endforeach
                                        <td class="text-center product_id_{{$order_product->product_id}}"><span
                                                    class="unit_price">{{$order_product->unit_price}}</span></td>
                                        <td class="text-center product_id_{{$order_product->product_id}}">
                                            <div class="relative pl_minus">
                                                @if($order_custumer->active_status<3)
                                                    {{--                                                                                                        <img onclick="decreaseQty({{$order_product->product_id}},{{$order_custumer->order_id }})" src="https://gopalganjbazar.com/web/images/minus-square.png" class="img inc" width="30px">--}}
                                                @endif
                                                <span class="cart_quantity">{{ $order_product->quantity }}</span>
                                            @if($order_custumer->active_status<3)
                                                {{--                                                                                                    <img onclick="increaseQty({{$order_product->product_id}},{{$order_custumer->order_id }})" src="https://gopalganjbazar.com/web/images/square-plus.png" class="img dec" width="30px"></div>--}}
                                            @endif
                                        </td>
                                        <td>&#2547;<span
                                                    id="totalP_{{$order_product->product_id}}">{{$order_product->total_price}}</span>
                                        </td>
                                        <td class="buy_price_td" id="p_total_{{$order_product->product_id}}">
                                            @foreach ($products  as $product)
                                                @if($order_product->product_id ==$product->id)
                                                    @if($order_product->total_buy_price > 0)
                                                        &#2547;{{$order_product->total_buy_price}}
                                                    @else
                                                        &#2547;{{$product->buy_price * $order_product->quantity }}
                                                    @endif
                                                @endif
                                            @endforeach

                                        </td>

                                        @foreach ($products  as $product)
                                            @if($order_product->product_id ==$product->id)

                                                @if($order_product->total_buy_price > 0)
                                                    @if(Auth::user()->role === 'admin')
                                                        <td class="buy_price_td">
                                                            <input type="text" id="input_{{$order_product->product_id}}"
                                                                   title="Single Product Buy Price"
                                                                   value="{{$order_product->total_buy_price / $order_product->quantity }}"
                                                                   class="form-control singlePrice"
                                                                   style="width: 76px;padding: 0 3px;"/>
                                                        </td>
                                                    @endif
                                                @else
                                                    <td class="buy_price_td">
                                                        <input type="text" id="input_{{$order_product->product_id}}"
                                                               title="Single Product Buy Price"
                                                               value="{{$product->buy_price}}"
                                                               class="form-control singlePrice"
                                                               style="width: 76px;padding: 0 3px;"/>
                                                    </td>
                                                @endif

                                            @endif

                                        @endforeach




                                        @foreach ($products  as $product)
                                            @if($order_product->product_id ==$product->id)

                                                @if($different_days<2)
                                                    @if($order_product->total_buy_price > 0)
                                                        @if(Auth::user()->role === 'admin')
                                                            <td class="buy_price_td">
                                                                <button onclick="update_price({{$order_product->order_id}},{{$order_product->product_id}},{{ $order_product->quantity }})"
                                                                        type="button"
                                                                        class="btn btn-sm btn-info btn-block update_price">
                                                                    UPDATE
                                                                </button>
                                                            </td>
                                                        @endif
                                                    @else
                                                        <td class="buy_price_td">
                                                            <button onclick="update_price({{$order_product->order_id}},{{$order_product->product_id}},{{ $order_product->quantity }})"
                                                                    type="button"
                                                                    class="btn btn-sm btn-warning btn-block update_price">
                                                                SAVE
                                                            </button>
                                                        </td>

                                                    @endif
                                                @endif

                                            @endif

                                        @endforeach


                                    </tr>
                                @endforeach
                                <tr>

                                    <td colspan="5">
                                        <span class="pull-left" style="margin-left: 10px;font-size: 12px;text-transform: uppercase;">
                                            ORDER STATUS:
                                             @if($order_custumer->active_status==0)
                                                <span style="color: orange;">  Pending</span>
                                            @elseif($order_custumer->active_status==1)
                                                <span style="color: blue;"> Approved</span>
                                            @elseif($order_custumer->active_status==2)
                                                <span style="color: orange;"> In Transit</span>
                                            @elseif($order_custumer->active_status==3)
                                                <span style="color: green;"> Delivered</span>
                                            @elseif($order_custumer->active_status==4)
                                                <span style="color: red;"> Cancelled</span>
                                            @endif
                                        </span>

                                    <span class="pull-right"> Sub Total</span>
                                    </td>
                                    <td colspan="2">&#2547;{{$order_custumer->order_total}}</td>


                                </tr>
                                <tr>
                                    <td colspan="3" class="text-right">
                                        <div class="input-group">
                                            <input type="text" class="form-control" title="Delivery Address"
                                                   placeholder="Address" id="d_address"
                                                   value="{{ $order_custumer->address }}"/>
                                            @if($order_custumer->active_status!=3)
                                                <div class="input-group-btn">
                                                    <button class="btn btn-default"
                                                            onclick="updateShipping({{ $order_custumer->order_id }})"
                                                            type="button">
                                                        <i class="fa fa-save"></i>
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td colspan="2" class="text-right"> Delivery Charge</td>
                                    <td colspan="2">&#2547;{{ $order_custumer->delivery_charge }}</td>
                                </tr>

                                <tr>

                                    <td colspan="3" class="text-right">
                                        <div class="input-group">
                                            <input type="text" class="form-control" title="Customer Name"
                                                   placeholder="Customer Name" id="cus_name"
                                                   value="{{ $order_custumer->name }}"/>
                                            @if($order_custumer->active_status!=3)
                                                <div class="input-group-btn">
                                                    <button class="btn btn-default"
                                                            onclick="updateShipping({{ $order_custumer->order_id }})"
                                                            type="button">
                                                        <i class="fa fa-save"></i>
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td colspan="2" class="text-right"> Discount</td>
                                    <td colspan="2" class="orange">
                                        &#2547;-{{ $order_custumer->coupon_discount_amount }}</td>
                                </tr>
                                <tr>
                                    <td class="text-right" colspan="2">
                                    </td>
                                    <td colspan="3" class="text-right"> Total</td>
                                    <td colspan="2">
                                        &#2547; {{$order_custumer->order_total + $order_custumer->delivery_charge - $order_custumer->coupon_discount_amount}}
                                        <input type="hidden" value="{{$profit}}">
                                    </td>
                                </tr>
                                <tr>
                                    <td>D.M</td>
                                    <td>
                                        <select class="form-control" name="delivery_man_id" required>
                                            <option value="" selected="">Delivery Person</option>
                                            @foreach ($delivery_mans  as $delivery_man)
                                                <option @if($order_custumer->delivery_man_id===$delivery_man->id) selected=""
                                                        @endif value="{{$delivery_man->id}}">{{$delivery_man->name}}</option>
                                            @endforeach
                                        </select>
                                    </td>

                                    <td colspan="3" class="text-right">
                                        <select class="form-control" name="sms" style="width: 103px;float: left;">
                                            <option selected>SMS NO</option>
                                            <option value="YES">SMS YES</option>

                                        </select>
                                        <span style="position: relative;top: 8px;">Payment Type</span>
                                    </td>
                                    <td colspan="2">
                                        @if($order_custumer->payment_type==1)
                                            Bkash
                                        @elseif($order_custumer->payment_type==2)
                                            Cash On Delivery
                                        @elseif($order_custumer->payment_type==3)
                                           Nagad
                                        @elseif($order_custumer->payment_type==4)
                                            Deposit Money
                                        @endif
                                    </td>

                                </tr>


                                <tr>
                                    <td colspan="3">
                                        <div class="input-group">
                                            <input type="text" class="form-control" title="Write Your Note"
                                                   placeholder="Write Your Note" id="note"
                                                   value="{{ $order_custumer->notes }}"/>

                                                <div class="input-group-btn">
                                                    <button class="btn btn-default"
                                                            onclick="updateNote({{ $order_custumer->order_id }})"
                                                            type="button">
                                                        <i class="fa fa-save"></i>
                                                    </button>
                                                </div>

                                        </div>
                                    </td>
                                    <td colspan="4">

                                        @if($order_custumer->active_status==4)
                                        @elseif($order_custumer->active_status==3)
                                        @else
                                            <a href="#" data-toggle="modal" data-target="#customer_received"
                                               class="btn btn-warning btn-sm pull-right mr15">CUSTOMER RECEIVED
                                                ORDER</a>
                                        @endif
                                    </td>


                                </tr>
                                <tr>
                                    <td colspan="6"
                                        class="status_show @if($order_custumer->active_status==3) done @elseif($order_custumer->active_status==4) cancel @endif">
                                        <input type="hidden" id="thisorder_id" name="order_id" value="{{ $order_id }}">
                                        <div class="steps-bar">

                                            <span>1<br/>
                                  <label><input type="radio" name="status" value="approve"
                                                @if($order_custumer->approve_status==1) disabled @endif />     Order Created</label>

                                 </span>
                                            <span>2<br/>
                                  <label><input type="radio" name="status" value="transit"
                                                @if($order_custumer->transit_status==1) disabled @endif />   In Transit</label>


                                 </span>
                                            @if($order_custumer->cancel_status==1)
                                                <span>3<br/>

                                  <label>

                                      <input type="radio" name="status" value="deivered"
                                                @if($order_custumer->delivered_status==1) disabled @endif />
                                      Deliver Successfully

                                  </label>


                                 </span>
                                            @else
                                                <span>3<br/>

                                  <label>
                                         @if($empty_buy_price_count ==0)
                                          <input type="radio" name="status" value="deivered"
                                                 @if($order_custumer->delivered_status==1) disabled @endif />   Deliver Successfully</label>

                                      @else
                                          Add Buy Price to Deliver
                                      @endif


                                 </span>
                                            @endif
                                            @if($order_custumer->delivered_status==1)
                                                <span>4<br/>

                                   <label><input type="radio" name="status" value="cancel"
                                                 @if($order_custumer->cancel_status==1) disabled @endif />   Cancel</label>

                                 </span>
                                            @else
                                                <span>4<br/>

                                   <label><input type="radio" name="status" value="cancel"
                                                 @if($order_custumer->cancel_status==1) disabled @endif />   Cancel</label>

                                 </span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                    </td>
                                    <td colspan="3">

                                        @if($order_custumer->active_status==3)

                                        @elseif($order_custumer->active_status==4)
                                        @else
                                            @if( $get_order_total->get_order_total==$order_custumer->order_total)

                                                <button type="submit" class="btn btn-primary btn-block">Submit</button>
                                            @endif
                                        @endif


                                    </td>
                                </tr>
                                <tr>

                                </tr>
                                </tbody>
                            </table>
                            {!! Form::close() !!}

{{--                                @if(Auth::user()->role === 'admin')--}}
{{--                                    {!! Form::open(['url' => 'ad/purchase-from-deposit-money','class'=>'form-vertical','enctype'=>'multipart/form-data','files'=>true ]) !!}--}}
{{--                                @endif--}}
{{--                                <input type="hidden" name="order_id" value="{{ $order_custumer->order_id }}">--}}
{{--                                <input type="hidden" name="phone" value="{{ $order_custumer->phone }}">--}}
{{--                                <input type="hidden" name="order_total" value="{{$order_custumer->order_total + $order_custumer->delivery_charge - $order_custumer->coupon_discount_amount}}">--}}

{{--                                <button class="btn  btn-warning btn-sm">PURCHASE FROM DEPOSIT MONEY</button>--}}
{{--                                {!! Form::close() !!}--}}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="customModal" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Custom Product</h4>
                </div>

                <div class="row modal-body custom-sale">
                    <input type="hidden" id="pp_id" class="form-control">
                    <input type="hidden" id="order_id" class="form-control">
                    <input type="hidden" id="old_total_price"/>

                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Custom Product Title (EN):</label>
                            <input type="text" id="custom_name_en" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Custom Product Title (BN):</label>
                            <input type="text" id="custom_name_bn" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Product Quantity:</label>
                            <input type="number" onchange="calcuateValue()" onkeyup="calcuateValue()" step="any"
                                   id="pp_qty" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Unit Price:</label>
                            <input type="number" step="any" onkeyup="calcuateValue()" onchange="calcuateValue()"
                                   id="pp_unit_price" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Total:</label>
                            <input type="number" step="any" id="pp_total_price" class="form-control">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">

                    <button type="button" onclick="updateSingleProduct()" class="btn btn-success btn-block">Update
                    </button>
                </div>

            </div>
        </div>
    </div>
    <div class="modal   fade" id="myModal" role="dialog">
        <div class="modal-dialog" style="max-width: 376px !important;">

            <!-- Modal content-->
            <div class="modal-content">

                <div class="modal-body text-center">
                    <h4 style="line-height: 28px;">Are You Sure?<br/>You want to remove This Item From cart.</h4>
                </div>
                <div class="modal-footer" style="border: none; text-align: center;">
                    <a href="" id="deleteBtn" class="btn btn-danger deleteBtn" data-morder="" data-mproduct=""
                       onclick="orderCustomize()">Delete</a>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>

        </div>
    </div>
    <div class="modal   fade" id="customer_received" role="dialog">
        <div class="modal-dialog" style="max-width: 376px !important;">

            <!-- Modal content-->
            <div class="modal-content">

                <div class="modal-body text-center">
                    <h4 style="line-height: 28px;color: #388e3c;margin-top: 34px;">Are You Sure?<br/>Customer received
                        Order Successfully.</h4>
                </div>
                <div class="modal-footer" style="border: none; text-align: center;">



                        {!! Form::open(['url' => 'shop/order/customer-order-received-status','class'=>'form-vertical','enctype'=>'multipart/form-data','files'=>true ]) !!}


                    {{ csrf_field() }}
                    <input type="hidden" name="order_id" value="{{$order_custumer->order_id }}">
                    <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                    <button type="submit" name="yes" class="btn  btn-success">Yes</button>
                    {!! Form::close() !!}
                </div>
            </div>

        </div>
    </div>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>
    <style>
        .steps-bar span.selected {
            background: #f273a9;
            color: #fff;
            font-weight: normal;
        }

        .steps-bar span.selected label {
            font-weight: normal;
        }
    </style>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        let _token = $('meta[name="csrf-token"]').attr('content');



        jQuery(".steps-bar span").click(function (event) {
            jQuery(".steps-bar span").removeClass("selected");
            jQuery(this).addClass("selected");
        });


        function calcuateValue() {

            let quantity = $("#pp_qty").val();
            let price = $("#pp_unit_price").val();
            let total = quantity * price;
            $("#pp_total_price").val(total);
        }


        function CustomProductModal(order_id, product_id, order_quantity, unit_price, total_price) {

            $("#customModal").modal();
            $('#pp_id').val(product_id);
            $('#order_id').val(order_id);
            $('#pp_qty').val(order_quantity);
            $('#pp_unit_price').val(unit_price);
            $('#pp_total_price').val(total_price);
            $('#old_total_price').val(total_price);

            let name_bn = $('#product_' + product_id + ' .name_bn').val();
            let name_en = $('#product_' + product_id + ' .name_en').val();

            $('#custom_name_en').val(name_en);
            $('#custom_name_bn').val(name_bn);


        }

        function updateSingleProduct() {
            let product_id = $('#pp_id').val();
            let order_id = $('#order_id').val();
            let order_quantity = $('#pp_qty').val();
            let unit_price = $('#pp_unit_price').val();
            let total_price = $('#pp_total_price').val();
            let custom_name_en = $('#custom_name_en').val();
            let custom_name_bn = $('#custom_name_bn').val();
            let total_buy_price = $('#pp_total_buy_price').val();
            let _token = $('meta[name="csrf-token"]').attr('content');
            let old_total_price = $('#old_total_price').val();

            $.ajax({
                type: 'POST',
                @if(Auth::user()->role === 'admin')
                url: '/web/ad/order/product-customize',
                @elseif(Auth::user()->role === 'manager')
                url: '/web/pm/order/product-customize',
                @elseif(Auth::user()->role === 'author')
                url: '/web/au/order/product-customize',
                @endif
                data: {
                    product_id: product_id,
                    order_id: order_id,
                    order_quantity: order_quantity,
                    unit_price: unit_price,
                    total_price: total_price,
                    custom_name_en: custom_name_en,
                    custom_name_bn: custom_name_bn,
                    total_buy_price: total_buy_price,
                    old_total_price: old_total_price,
                    _token: _token
                },
                success: function (data) {
                    console.log(data);
                    Command: toastr["info"]("Updated Successfully.");
                    location.reload();
                }
            });


        }


        function increaseQty(product_id, order_id) {
            var retVal = confirm("Do you want to Increase Quantity");
            if (retVal == true) {
                let product_quantity = $(".product_id_" + product_id + ' .cart_quantity').text();
                let unitPrice = parseInt($(".product_id_" + product_id + ' .unit_price').text());
                let newQty = parseInt(product_quantity) + 1;
                $(".product_id_" + product_id + ' .cart_quantity').text(newQty)
                $.ajax({
                    type: 'GET',
                    @if(Auth::user()->role === 'admin')
                    url: '/web/ad/order/admin-custom-order-product-increase/' + order_id + '/' + product_id + '/' + product_quantity + '/' + newQty + '/' + unitPrice,
                    @elseif(Auth::user()->role === 'manager')
                    url: '/web/pm/order/admin-custom-order-product-increase/' + order_id + '/' + product_id + '/' + product_quantity + '/' + newQty + '/' + unitPrice,
                    @elseif(Auth::user()->role === 'author')
                    url: '/web/au/order/admin-custom-order-product-increase/' + order_id + '/' + product_id + '/' + product_quantity + '/' + newQty + '/' + unitPrice,

                    @endif
                    dataType: "json",
                    success: function (data) {
                        console.log(data);
                        Command: toastr["info"]("New Quantity Updated Successfully.");
                        location.reload();
                    }
                });
                return true;
            } else {

                return false;
            }

        }


        function decreaseQty(product_id, order_id) {
            var retVal = confirm("Do you want to Decrease Quantity");
            if (retVal == true) {
                let product_quantity = parseInt($(".product_id_" + product_id + ' .cart_quantity').text());
                let unitPrice = parseInt($(".product_id_" + product_id + ' .unit_price').text());

                if (product_quantity > 1) {
                    let newQty = product_quantity - 1;
                    $(".product_id_" + product_id + ' .cart_quantity').text(newQty)
                    $.ajax({
                        type: 'GET',
                        @if(Auth::user()->role === 'admin')
                        url: '/web/ad/order/admin-custom-order-product-decrease/' + order_id + '/' + product_id + '/' + product_quantity + '/' + newQty + '/' + unitPrice,
                        @elseif(Auth::user()->role === 'manager')
                        url: '/web/pm/order/admin-custom-order-product-decrease/' + order_id + '/' + product_id + '/' + product_quantity + '/' + newQty + '/' + unitPrice,
                        @elseif(Auth::user()->role === 'author')
                        url: '/web/au/order/admin-custom-order-product-decrease/' + order_id + '/' + product_id + '/' + product_quantity + '/' + newQty + '/' + unitPrice,

                        @endif
                        dataType: "json",
                        success: function (data) {
                            console.log(data);
                            Command: toastr["info"]("New Quantity Updated Successfully.");
                            location.reload();
                        }
                    });
                }
                return true;
            } else {

                return false;
            }

        }


        function updateShipping(order_id) {
            let address = $("#d_address").val();
            let customer_name = $("#cus_name").val();
            $.ajax({
                type: 'GET',
                url: '/shop/order/update-shipping/' + order_id + '/' + address + '/' + customer_name,
                dataType: "json",
                success: function (data) {
                    alert();
                    console.log(data);
                    Command: toastr["info"]("Shipping Updated Successfully.");
                }
            });

        }

        function updateNote(order_id) {
            let note = $("#note").val();
            if(note == null){
                let note = ' ';
            }
            //alert(note);
            $.ajax({
                type: 'GET',
                url: '/web/shop/order/update-note/' + order_id + '/' + note,
                dataType: "json",
                success: function (data) {
                    console.log(data);
                    Command: toastr["info"]("Note Updated Successfully.");
                }
            });

        }


        function openModal(order_id, product_id, quantity) {

            $("#myModal").modal();
            //click  delete  button  call  this operation
            $('#deleteBtn').attr("href", '/web/shop/order/custom-order/' + order_id + '/' + product_id + '/' + quantity);


        }

        function orderCustomize() {
            var product_id = $('.deleteBtn').attr('data-mproduct');
            var order_id = $('.deleteBtn').attr('data-morder');
             
        }


    </script>
    <script>

        //$(".courierinfo").hide();
        // function getval(sel)
        //{
        // if(sel.value==4){  date('Y-m-d', strtotime($order_custumer->created_at)) == date('Y-m-d')

        // $(".courierinfo").show();
        // }else{
        //   $(".courierinfo").hide();
        // }
        //}

        $(".buy_price_td,.buy_price_th").hide();

        function update_fields_show() {
            $(".buy_price_td,.buy_price_th").toggle();
        }

        function update_price(order_id, product_id, order_quantity) {

            var p = $("#input_" + product_id).val();
            if (p > 0) {
                var product_price = p * order_quantity;

                $("#p_total_" + product_id + " span").text(product_price);
                var buyPrice = $("#totalP_" + product_id).text();
                if (buyPrice < product_price) {
                    alert("BUY Price Is Bigger Than Sell Price. BUY PRICE:" + product_price + " SELL PRICE:" + buyPrice);
                }
                $.ajax({
                    type: 'GET',
                    url: '/web/shop/order-product-buy-price-update/' + order_id + '/' + product_id + '/' + product_price,
                    dataType: "json",
                    success: function (data) {
                        console.log(data);
                        Command: toastr["info"]("Buy Price Updated Successfully.");
                    }
                });
            } else {
                alert('Input Product Buy Price');
            }


        }


    </script>

@endsection
