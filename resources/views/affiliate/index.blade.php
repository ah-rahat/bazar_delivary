
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
                    <div class="panel-heading">Add Affiliate Customers  </div>
                    <div class="panel-body">
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-right mt10">Affiliate User</label>
                            <div class="col-md-6">
                                <select  id="affiliator_id" class="form-control selectpicker "  data-live-search="true" name="affiliate_user_id" required>
                                    <option value="" selected="">Select Affiliate User</option>
                                    @foreach ($marketers as $index => $marketer)
                                    <option value="{{$marketer->id}}">  {{$marketer->name}} <small> ( {{$marketer->phone}} )</small></option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-right mt10">Customer Phone</label>
                            <div class="col-md-6">
                                <input type="number" id="customer_phone" step="any" class="form-control" placeholder="Type Phone  Number" required="">
                            </div>
                        </div>
                            <div class="form-group row result">
                                <label for="name" class="col-md-4 col-form-label text-right mt10 red">Customer Match</label>
                                <div class="col-md-6"> 
                                    Customer Registered Date: <span class="regdate"></span><br>
                                    First Order Date: <span class="orderdate"></span>
                                </div>
                            </div>


                        <div class="form-group row mb-0">
                            <label   class="col-md-4 col-form-label text-md-right"> </label>
                            <div class="col-md-6 offset-md-4">
                                <button type="button" onclick="assign_customer()" class="btn btn-primary">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
               <div class="panel panel-info">
                   <div class="panel-body" style="padding:  7px 15px !important;">
                       <div style="color: #7cb342;
text-transform: uppercase;font-weight: 600;font-size: 13px; ">
                           Affiliate User 10% Profit Commission Amount:
                           <b class="pull-right" style="color: #ff8f00;font-size: 15px;">
                               &#2547;<span class="amount">0</span>
                           </b>
                       </div>
                   </div>
                   <div class="panel-body" style="padding:  7px 15px !important;">
                       <div style="color: #7cb342;
text-transform: uppercase;font-weight: 600;font-size: 13px; ">
                           Sales Amount:
                           <b class="pull-right" style="color: #ff8f00;font-size: 15px;">
                               &#2547;<span class="sales">0</span>
                           </b>
                       </div>
                   </div>
                   <div class="panel-body" style="padding:  7px 15px !important;">
                       <div style="color: #7cb342;
text-transform: uppercase;font-weight: 600;font-size: 13px; ">
                           Total Profit Amount:
                           <b class="pull-right" style="color: #ff8f00;font-size: 15px;">
                               &#2547;<span class="profit">0</span>
                           </b>
                       </div>
                   </div>
               </div>

            </div>
        </div>
    </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}" />
<script>


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });


    function  assign_customer(){
        let affiliator_id=  $('#affiliator_id').val();
        let customer_phone= $('#customer_phone').val();
        let _token   = $('meta[name="csrf-token"]').attr('content');
if(customer_phone.length==11){
        $.ajax({
            type:'POST',
            url:'/web/ad/affiliate/customer/add',
            data:{
            affiliator_id:affiliator_id,
            customer_phone:customer_phone,
            _token: _token
        },
        success:function(data) {
            console.log(data);
            if(data.error){
                Command: toastr["error"]("Number Exist.");
            }else{
                Command: toastr["info"]("Added Successfully.");
            }


         }
    });
}else{
    alert('Phone  Number Invalid');
}


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

    function update_fields_show(){
        $(".buy_price_td,.buy_price_th").toggle();
    }

    function update_price(order_id,product_id,order_quantity){

        var p = $("#input_"+product_id).val();
        if(p>0){
            var  product_price= p * order_quantity;

            $("#p_total_"+product_id + " span").text(product_price);
            var buyPrice= $("#totalP_"+product_id).text();
            if(buyPrice<product_price){
                alert("BUY Price Is Bigger Than Sell Price. BUY PRICE:"+buyPrice+ " SELL PRICE:"+product_price);
            }
            $.ajax({
                type:'GET',
                @if(Auth::user()->role === 'admin')
            url:'/web/ad/order-product-buy-price-update/'+order_id+'/'+product_id+'/'+product_price,
            @else(Auth::user()->role === 'manager')
            url:'/web/pm/order-product-buy-price-update/'+order_id+'/'+product_id+'/'+product_price,
            @endif
            dataType: "json",
                success:function(data) {
                console.log(data);
                Command: toastr["info"]("Buy Price Updated Successfully.");
            }
        });
        }else{
            alert('Input Product Buy Price');
        }


    }



</script>

@endsection
@section('footerjs')
<script>
    $('.selectpicker').change(function () {
        let _token   = $('meta[name="csrf-token"]').attr('content');
        var selectedItem = $('.selectpicker').val();
        $.ajax({
            type:'POST',
            url:'/web/ad/affiliate-user-activity',
            data:{
                affiliator_id:selectedItem,
                _token: _token
            },
            success:function(data) {
                console.log(data.affiliate_commission);
                $('.amount').text(data.affiliate_commission);
                $('.sales').text(data.sales);
                $('.profit').text(data.profit);
            }
        });
    });
    $('.result').hide();
    $('#customer_phone').change(function () {
       let  number = $(this).val();
        $('.result').hide();
        $('.result .regdate').text('');
        $('.result .orderdate').text('');
       if(number.length == 11){
           let  number = $(this).val();

           let _token   = $('meta[name="csrf-token"]').attr('content');
           $.ajax({
               type:'POST',
               datatype:'json',
               url:'/web/ad/customer-activity-search/'+number,
               data:{
                   _token: _token
               },
               success:function(data) {
                   console.log(data);
                   $('.result').show();
                   $('.result .regdate').text(data.customer.created_at);
                   $('.result .orderdate').text(data.order.created_at);
               }
           });
       }

    });
</script>

@endsection
