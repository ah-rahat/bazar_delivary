<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <title> Gopalganj Bazar | Online Shop in Gopalganj City</title>

    <!-- Scripts -->
    <!--
        -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://use.fontawesome.com/b95bd32606.js"></script>
    <link href="https://gopalganjbazar.com/web/css/style.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/f2988b3c12.js">
    </script>

</head>
<body>
<div class="cstom-order" id="app" v-cloak>
    <div class="loadershow"><img src="https://gopalganjbazar.com/static/img/loader-zig.93b11f9.gif"></div>
    <div class="header-top">
        <button type="button" class="navbar-toggle" id="colapsebtn">
            <i class="fa fa-th"></i>
        </button>
    </div>
    <main>
        <div>
            <div class="container-fluid mt10">
                <div class="row justify-content-center">

                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="panel" style="margin-bottom:   5px;">
                                    <div class="panel-body" style="padding: 1px !important;">
                                        <div class="input-group input-daterange report_date_range">
                                            {{--                                    <input type="text" class="form-control start" placeholder="From  YY-MM-DD">--}}
                                            <div class="input-group-addon"><i class="fa fa-user-o" aria-hidden="true"></i></div>
                                            <input type="text" class="form-control end" v-model="name"
                                                   placeholder="Customer Name">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="panel" style="margin-bottom:   5px;">
                                    <div class="panel-body" style="padding: 1px !important;">
                                        <div class="input-group input-daterange report_date_range">
                                            {{--                                    <input type="text" class="form-control start" placeholder="From  YY-MM-DD">--}}
                                            <div class="input-group-addon"><i class="fa fa-phone"></i></div>
                                            <input type="text" class="form-control end" v-model="phone"
                                                   @change="findCustomer"  placeholder="Phone">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="panel" style="margin-bottom:   5px;">
                                    <div class="panel-body" style="padding: 1px !important;">
                                        <input  type="hidden" id="customer_id" value="{{Auth::user()->id}}" />
                                        <div class="input-group input-daterange report_date_range relative">
                                            <div class="input-group-addon"><i class="fa fa-map-marker" aria-hidden="true"></i></div>
                                            <input type="text" class="form-control end" v-model="area" :readonly="areaSelected"
                                                   placeholder="Area.." >
                                            {{--                                            <select class="selectpicker"    @change="updateDeliveryCharge()" data-fieldname = "area" ref="area"   v-model="area"  width="220px">--}}
                                            {{--                                                <option v-for="l in locations"  :value="l.location_name" >!{l.location_name}!</option>--}}
                                            {{--                                            </select>--}}
                                            <div class="close"  v-if="areaSelected" @click="removeArea"><i class="fa fa-times-circle-o" aria-hidden="true"></i></div>
                                            <div class="areaList" v-if="getSearchAreaList.length>0">
                                                <div class="area" v-for="(getAre,index)  in getSearchAreaList" @click="areaAssign(getAre.delivery_charge,getAre.location_name+ '('+getAre.location_name_bn+')',getAre.min_order_amount,getAre.location_id,getAre.delivery_time_slot)" ><i aria-hidden="true" class="fa fa-map-marker"></i> !{getAre.location_name}! (!{getAre.location_name_bn}!)</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="panel" style="margin-bottom:   5px;">
                                    <div class="panel-body" style="padding: 1px !important;">
                                        <div class="input-group input-daterange report_date_range">
                                            {{--                                    <input type="text" class="form-control start" placeholder="From  YY-MM-DD">--}}
                                            <div class="input-group-addon"><i class="fa fa-home"></i></div>
                                            <input type="text" class="form-control end" v-model="address"
                                                   placeholder="Delivery Address..">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel">
                            <div class="panel-body">
                                <b style="
font-weight: normal;
position: relative;
top: -8px;" v-if="min_order_amount"> Order Minimum <b style="color: #AD1457 !important;">!{ min_order_amount }!</b> Taka to get free delivery</b>
                                <div class="row">
                                    <div class="col-md-12" style="padding-bottom: 20px;">
                                        <div class="each-option"  v-if="timeSlots.length > 0">
                                            <div class="extra_first" @click="ToogleTime">
                                                <div class="pull-left" style="padding-right: 10px;">
                                                    <img src="data:image/png;base64,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" height="35px"></div> <div class="pdt4"><div style="overflow: hidden; cursor: pointer;"><span style="font-weight: 500;">
                      Set delivery time .<i class="fa fa-angle-down pull-right" style="font-size: 18px;margin-top: 7px; margin-right: 10px; color: rgb(0, 0, 0);"></i></span> <br> <!---->
                                                        <span v-if="expectedDeliveryTime" style="color: rgb(233, 30, 99); font-weight: 600;">
                                                            !{expectedDeliveryTime}!  !{expectedDeliveryStartTime}! - !{expectedDeliveryEndTime}!</span>
                                                        <span v-else style="color: rgb(233, 30, 99); font-weight: 600;">Delivery time not Set.</span>
                                                    </div>
                                                </div></div>
                                            <div class="delivery-time" v-if="deliverySlot">
                                                <div class="single-slot"  v-for="(timeSlot, index) in timeSlots"  @click="DeliveryTimeSet(index,timeSlot.start,timeSlot.end,'Today')">
                                                    <div class="pull-left" style="padding-right: 10px;"><img
                                                                src="data:image/png;base64,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"
                                                                style="margin-top: 6px;" height="26px"></div>
                                                    <div class="pdt4"><span style="font-weight: 500;">
                    Delivery Time  </span> <br> <span style="color: rgb(233, 30, 99); font-weight: 600;">  Today !{ timeSlot.start }!
                          !{ timeSlot.end }!</span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 table-responsive">
                                        <div class="table-responsive panel summary-report plists_show carts_table"><table class="table plists" style="text-transform: none !important;"><thead>
                                                <tr><th>Photo</th>
                                                    <th>Name</th>
                                                    <th class="text-center">Unit&nbsp;Price</th>
                                                    <th class="text-center">O.Qty</th>
                                                    <th width="100px">Total</th></tr></thead>
                                                <tbody>

                                                <tr v-for="(cart, index) in carts" :class="'product_id'+cart.product_id">
                                                    <td width="60px" @click="removeCartItem(cart.product_id)">
                                                        <div class="relative">
                                                            <img class="pimg" width="60px"
                                                                 :src="'https://gopalganjbazar.com/web/uploads/products/' +cart.product_image"/>
                                                            <img class="plus" width="50px"
                                                                 src="https://gopalganjbazar.com/web/images/minus.png"/>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <div> !{cart.product_name}! !{cart.strength}! !{cart.quantity}!
                                                                !{cart.unit}! </div>
                                                        </div>
                                                        <div><small>!{cart.product_name_bn}! !{cart.strength}! !{cart.quantity}!
                                                                !{cart.unit}!</small></div>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="price">&#2547;!{cart.price}!</span>
                                                    </td>
                                                    <td class="text-center" :id="cart.product_id">
                                                        <div class="relative pl_minus">
                                                            <img @click="cartDecrement(cart.product_id)" class="img inc"  width="30px"
                                                                 src="https://gopalganjbazar.com/web/images/minus-square.png"/>

                                                            <span class="cart_price cart_quantity">!{cart.cart_quantity}!</span>
                                                            <img @click="cartIncrement(cart.product_id)" class="img dec" width="30px"
                                                                 src="https://gopalganjbazar.com/web/images/square-plus.png"/>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="cart_price">&#2547; !{cart.subtotal}!</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" class="text-right text-uppercase">

                                                        Sub Total</td>
                                                    <td style="padding:10px; "><span class="price">&#2547; !{sum_cart_total}!</span></td>

                                                </tr>
                                                <tr  v-if="bill_total < min_order_amount">
                                                    <td colspan="5" class="text-right text-uppercase" style="padding: 10px !important;">
                                                        <b style="color: #AD1457 !important;"><i class="fa fa-info-circle"></i> To get free delivery Order Minimum <b >!{ min_order_amount }!</b> Taka </b>

                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <select class="form-control" v-model="deliveryManId" style="width: 200px;">
                                                            <option  value=" ">DeliveryPerson</option>
                                                            <option v-for="deliveryMan in deliveryMans" :value="deliveryMan.id">!{deliveryMan.name}! !{deliveryMan.phone}!</option>
                                                        </select></td>
                                                    <td colspan="2" class="text-right text-uppercase">  Delivery Charge</td>
                                                    <td style="padding:10px; "><span class="price">&#2547; !{delivery_charge}!</span></td>

                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <span class="price finalprice">
                                                                <b class="pull-left " style="margin-right: 10px">SMS:</b>
                                                            <label class="pull-left" style="margin-right: 10px" for="Yes">
                                                                <input type="radio" id="Yes" value="1" v-model="sms">Yes</label>
                                                                <label for="No"   class="pull-left"><input type="radio" id="No"  value="0" v-model="sms" >
                                                                No</label>
                                                                </span>
                                                    </td>
                                                    <td colspan="2" class="text-right text-uppercase orange">  Discount  </td>
                                                    <td style="padding:10px;position: relative; ">
                                                        <span style="position: absolute;font-size: 23px;color: #AD1457 !important">-</span>
                                                        <span class="price orange">
{{--                                                            &#8722;--}}
                                                            <input style="padding-left: 13px !important;box-shadow: none;border: none;" class="form-control orange" width="60px" type="text"  v-on:input="calculateCartTotal()"  v-model="discount"></span>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                                <span class="price finalprice">
                                                                <label for="Cash">
                                                                <input type="radio" id="Cash" value="2" v-model="payment_type"  selected >Cash</label>
                                                                <label for="Bkash"><input type="radio" id="Bkash"   value="1" v-model="payment_type" >
                                                                Bkash</label>
                                                                </span>
                                                    </td>
                                                    <td class="text-right text-uppercase green" colspan="2">   Total 	   </td>
                                                    <td style="padding:10px; "><span class="price finalprice">&#2547; !{bill_total}!</span></td>

                                                </tr>
                                                <tr>
                                                    <td class="text-right text-uppercase green" colspan="2">
                                                    <textarea class="form-control" placeholder="Customer Note" v-model="notes"  id="customer_note"  style="height: 40px;"></textarea>
                                                    </td>
                                                    <td  style="padding: 10px;"  colspan="5" v-if="carts.length>0">
                                                        <button type="button" class="btn btn-block createOrder" @click="createOrder">CREATE ORDER</button>
                                                    </td>
                                                </tr>
                                                </tbody></table></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel" style="margin-bottom:   5px;">
                            <div class="panel-body" style="padding: 1px !important;">

                                <div class="input-group input-daterange report_date_range">
                                    {{--                                    <input type="text" class="form-control start" placeholder="From  YY-MM-DD">--}}
                                    <div class="input-group-addon">Products</div>
                                    <input type="text" class="form-control end" v-model="SearchValue"
                                           @keyup.enter="searchProducts" placeholder="Product Name........">
                                </div>

                            </div>
                        </div>
                        <div class="panel summary-report plists_show">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        {{--                                        <span> </span> <span class="  text-right date-show"><i--}}
                                        {{--                                                    class="fa fa-calendar-check-o" aria-hidden="true"></i>  <span>Aug 24   -   Feb 10</span>  Sales</span>--}}
                                        <div class="table-responsive">
                                            <table class="table plists" style="text-transform: none !important;">
                                                <thead>
                                                <tr>
                                                    <th>Photo</th>
                                                    <th>Name</th>
                                                    <th class="text-center">Price</th>
                                                    <th class="text-center">Qty</th>
                                                    <th class="text-center">InStock</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr v-for="(product, index) in products" v-bind:class="{ inactive: product.status == 0 }" >
                                                    <td width="60px">
                                                        <div v-if="product.stock_quantity > 0">
                                                            <div class="relative" @click="createCarts(index,product.id)"  v-if="product.stock_quantity > 0 ">
                                                                  <img class="pimg" width="60px"
                                                                     :src="'https://gopalganjbazar.com/web/uploads/products/' +product.featured_image"/>

                                                                <img class="plus" width="50px"
                                                                     src="https://gopalganjbazar.com/web/images/plus.png"/>
                                                            </div>
                                                        </div>
                                                            <div v-else>
                                                                <div class="relative">
                                                                    <img class="pimg" width="60px"
                                                                         :src="'https://gopalganjbazar.com/web/uploads/products/' +product.featured_image"/>
                                                                </div>
                                                            </div>
                                                    </td>
                                                    <td>
                                                        <img v-if="product.real_stock == 1" src="https://gopalganjbazar.com/web/images/badge.png" style="width: 20px;float: left;margin-right: 8px;"/>
                                                        <div>!{product.name}! !{product.strength}! !{product.unit_quantity}!
                                                            !{product.unit}!
                                                        </div>
                                                        <div><small>!{product.name_bn}! !{product.strength}! !{product.unit_quantity}!
                                                                !{product.unit}!</small></div>
                                                        <div v-if="product.restaurant_id">
                                                            <small v-for="(restaurent, index) in restaurents" v-if="product.restaurant_id==restaurent.id"><i class="fa fa-cutlery" aria-hidden="true"></i> !{restaurent.restaurant_name_bn}!</small>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="price">&#2547;!{product.price-product.discount}!</span>
                                                    </td>
                                                    <td class="text-center">!{product.unit_quantity}!!{product.unit}!</td>

                                                    <td class="text-center">
                                                        !{product.stock_quantity}!
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
        <div id="messagearea"></div>

    </main>
</div>
<style>
    .each-option{
        border-radius: 3px;
        border: 1px solid #eaeaea !important;
        padding: 6px 10px 6px 10px;
        font-size: 11px;
        text-transform: uppercase;
        position: relative;
    }
    .single-slot {
        border-radius: 3px;
        border: 1px solid #eaeaea !important;
        padding: 6px 10px 6px 10px;
        font-size: 11px;
        text-transform: uppercase;
        margin-bottom: 5px;
        cursor: pointer;
        float: left;
        width: 50%;
    }

    .single-slot:hover{
        border: 1px solid rgb(233, 30, 99) !important;
    }
    .delivery-time {
        margin-top: 10px;
        position: relative;
        top: 15px;
        margin-bottom: 30px;
    }
    .message b{
        color: #000;
    }
    .message a{
        color: #00897b;
    }
    .message b i{
        color: #00897b;
    }
    .message{
        position: fixed;
        right: 4px;
        bottom: 15px;
        background: rgb(255, 255, 255) none repeat scroll 0% 0%;
        border-radius: 4px;
        box-shadow: #00897b66 0px 1px 3px;
        border-left: 4px solid rgb(0, 137, 123);
        padding: 5px 15px;
    }
    .loadershow{
        position: absolute;
        height: 100vh;
        background: #ffffff87;
        vertical-align: middle;
        align-items: center;
        z-index: 1000;
        width: 100%;
        text-align: center;
        display: table-cell;
    }
    .loadershow img{
        height: 106px;
        margin-top: 152px;
        opacity: .6;
    }
    .message a.btn{
        color: #fff;
        margin-left: 5px;
    }
    .inactive{
        color: #AD1457 !important;
        text-transform: capitalize;
    }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/vue@2.5.21/dist/vue.js">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.12.0/underscore-min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>


<script>

    $(".loadershow").hide();
    jQuery('body').on('click', '#colapsebtn', function (e) {
        jQuery(".left-area").toggleClass("onofme");
    });
    jQuery(function () {

        var current = window.location;

        jQuery('.sidebar li a').each(function () {
            var $this = $(this);
            // if the current path is like this link, make it active
            if ($this.attr('href') == current) {
                $this.addClass('active');
                jQuery(this).parent().parent().addClass('in');
                jQuery(this).parent().parent().parent().addClass('top');
            }
        });

        // $(".nav-link.active").closest('collapse').addClass('in');
        //$(".nav-link.active").parents('collapse').addClass('in');
    });
    jQuery(document).ready(function () {
        // $('.selectpicker').on("change",function(){
        //
        // });
        // $('.js-example-basic-single').select2();
        // jQuery('.selectpicker').selectpicker();

        // jQuery.noConflict();

        //jQuery('select').select2();
        //jQuery('#example').dataTable(
        //{
        //  "order": []
        //}
        // );

        ///$('#datatable-keytable').DataTable( { keys: true } );
        // $('#datatable-responsive').DataTable();
    });
</script>
<script type="text/javascript">

    var app = new Vue({
        el: '#app',
        delimiters: ['!{', '}!'],
        data: {
            shippings: [],
            locations: [],
            products: [],
            carts: [],
            SearchValue: null,
            address: null,
            notes: '',
            name:null,
            deliveryManId:null,
            payment_type:2,
            phone: null,
            sms:0,
            area: null,
            location_id: null,
            sum_cart_total:0,
            min_order_amount:null,
            cartsCountProduct:0,
            delivery_man:null,
            discount:0,
            delivery_charge:0,
            bill_total:0,
            areaSelected:false,
            deliveryMans:[],
            restaurents:[],
            getSearchAreaList:[],
          delivery_time_slot:null,
          deliverySlot:false,
          timeSlots:[],
          expectedDeliveryTime :null,
          expectedDeliveryStartTime :null,
          expectedDeliveryEndTime :null,
          assignedDeliveryTime:null
        },
        watch: {
            area: function() {
                let vm=this;
                console.log(vm.area)
                let getSearchAreaList=vm.locations.filter(function(x) {
                    return x.location_name.toLowerCase().indexOf(vm.area.toLowerCase()) > -1;
                });
                vm.getSearchAreaList=getSearchAreaList;
              // vm.delivery_time_slot=vm.locations.filter(function(y) {
              //   return y.delivery_time_slot.indexOf(vm.area.toLowerCase()) > -1;
              // });
              //   console.log('getSearchAreaList',vm.delivery_time_slot);
            }
        },
        // updated: function(){
        //     this.$nextTick(function(){ $('.selectpicker').selectpicker('refresh'); });
        // },
        created: function () {
            //this.loadApiData();
            this.restaurentList();
            this.deliveryLocations();
            this.getDeliveryMans();
        },
        mounted() {
            let vm = this;
            if (localStorage.getItem("carts")) {
                vm.carts = JSON.parse(localStorage.getItem("carts"));
            } else {
                vm.carts = [];
            }
            $(this.$refs.area).selectpicker('refresh')
            this.calculateCartTotal();
            //after  page ready  this  function execute
            //this.$nextTick(function () {
            //});

        },
        methods: {
          ToogleTime: function () {
            this.deliverySlot = !this.deliverySlot;
          },
          DeliveryTimeSet: function (index, delivery_time_from,delivery_time_to,day) {
            // this.extraFastCharge= false;
            this.expectedDeliveryTimeEnable = null;
            if(day == 'Tomorrow'){
              this.expectedDeliveryTime = day + ' '+  moment(String(this.tomorrow)).format('ddd');
              this.expectedDeliveryStartTime =  delivery_time_from;
              this.expectedDeliveryEndTime =   delivery_time_to;
            }else{
              this.expectedDeliveryTime = day;
              this.expectedDeliveryStartTime = delivery_time_from;
              this.expectedDeliveryEndTime =  delivery_time_to;
            }
            this.deliverySlot = false;

          },
            restaurentList() {
                var vm = this;
                //alert(this.SearchValue);
                axios.get('https://gopalganjbazar.com/web/api/restaurants')
                    .then(function (response) {
                        // handle success
                        vm.restaurents = response.data.data;
                        console.log(response.data);
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    });

            },
            //carts  related  functions
            cartIncrement(product_id) {
                //alert(product_id);
                let objIndex = this.carts.findIndex((obj => obj.product_id == product_id));
                let oldQuantity = this.carts[objIndex].cart_quantity;
                let stock_quantity = this.carts[objIndex].stock_quantity;
                if(oldQuantity<stock_quantity){
                    let newQuantity = oldQuantity + 1;
                    let price = this.carts[objIndex].price;
                    this.carts[objIndex].cart_quantity = newQuantity;
                    this.carts[objIndex].subtotal = price * newQuantity;
                    localStorage.setItem("carts", JSON.stringify(this.carts));
                    this.carts = JSON.parse(localStorage.getItem("carts"));
                    //$('#'+product_id+ " .cart_quantity").text(newQuantity);
                    this.calculateCartTotal();
                }
            },
            cartDecrement(product_id) {
                let objIndex = this.carts.findIndex((obj => obj.product_id == product_id));
                let oldQuantity = this.carts[objIndex].cart_quantity;
                if (oldQuantity > 1) {
                    let newQuantity = oldQuantity - 1;
                    let price = this.carts[objIndex].price;
                    this.carts[objIndex].cart_quantity = newQuantity;
                    this.carts[objIndex].subtotal = price * newQuantity;
                    localStorage.setItem("carts", JSON.stringify(this.carts));
                    this.carts = JSON.parse(localStorage.getItem("carts"));
                    this.calculateCartTotal();
                    //$("#"+product_id +" .cart_quantity").text(newQuantity);

                }

            },
          formatTime: function (value) {
            if (value) {
              let momentObj = moment(value, ["h:mm"]);
              return momentObj.format("h:mm a");
            }
          },
            removeArea: function () {
                let vm=this;
                vm.areaSelected=false;
              vm.expectedDeliveryTime =null;
                vm.expectedDeliveryStartTime =null;
                vm.expectedDeliveryEndTime =null;
                vm.area='';
                vm.timeSlots=[];
            },
            areaAssign: function (delivery_charge,delivery_area,min_order_amount,location_id,delivery_time_slot) {
                let vm=this;
                vm.delivery_charge=delivery_charge;
                vm.location_id=location_id;
                vm.area=delivery_area;
                vm.min_order_amount=min_order_amount;
                vm.delivery_time_slot=delivery_time_slot;
                vm.areaSelected=true;
                console.log('location_id',location_id);
                console.log('delivery_time_slot',vm.delivery_time_slot);

              if(vm.delivery_time_slot){
                const timeArray = vm.delivery_time_slot.split(",");

               for (let i = 0; i < timeArray.length; i++) {

                  const timesArray = timeArray[i].split("-");
                //   // alert(typeof timeArray);

                  if (timesArray === undefined || timesArray.length == 0) {
                  } else {
                    //present  hour value
                    let startTime = timesArray[0];
                    // console.log(startTime);
                    let endTime = timesArray[1];

                    vm.timeSlots.push({
                      'start': this.formatTime(startTime),
                      'end': this.formatTime(endTime)
                      // 'status': true,
                    })
                    }
                  }

                }
                   console.log('76', vm.timeSlots);
                this.calculateCartTotal();
            },
            // updateCharge () {
            //     vm.discount=this.discount;
            //     this.calculateCartTotal();
            // },
            updateDeliveryCharge: function () {
                alert();
            },
            createCarts: function (index, product_id) {
                let vm = this;
                let result = JSON.parse(localStorage.getItem("carts"));
                       if (result == null)
                           result = [];
                var  ifFind= result.filter(function (obj) {
                    return obj.product_id === product_id;
                });
                // console.log(ifFind.length);

                if(ifFind.length == 0){

                      // if(this.products[index].real_stock != 1 && this.products[index].stock_quantity != 0){
                      //
                      // }
                    let price = (this.products[index].price - this.products[index].discount);
                    //console.log(price);
                    result.unshift({
                        'product_id': this.products[index].id,
                        'product_name': this.products[index].name,
                        'product_name_bn': this.products[index].name_bn,
                        'product_image': this.products[index].featured_image,
                        'price': price,
                        'image': this.products[index].featured_image,
                        'strength': this.products[index].strength,
                        'quantity': this.products[index].unit_quantity,
                        'unit': this.products[index].unit,
                        'real_stock': this.products[index].real_stock,
                        'cart_quantity': 1,
                        'stock_quantity': this.products[index].stock_quantity,
                        'subtotal': price * 1
                    });
                    // save the new result array
                    localStorage.setItem("carts", JSON.stringify(result));
                    vm.carts = JSON.parse(localStorage.getItem("carts"));
                    this.calculateCartTotal();
                }else{
                    alert('Already in  your Bag')
                }

            },
            calculateCartTotal() {
                let vm = this;
                for (var i = 0, sum = 0; i < vm.carts.length; sum += vm.carts[i++].subtotal) ;
                vm.sum_cart_total = sum;
                for (var i = 0, totalSum = 0; i < vm.carts.length; totalSum += vm.carts[i++].cart_quantity) ;
                vm.cartsCountProduct = totalSum;
                localStorage.setItem("cartsCountProduct", totalSum);
                vm.bill_total=sum+vm.delivery_charge-vm.discount;
            },
            removeCartItem: function (product_id) {
                //alert(product_id);
                this.carts = this.carts.filter((e) => e.product_id !== product_id);
                $("#"+product_id).removeClass('cartAdded');
                localStorage.setItem("carts", JSON.stringify(this.carts));
                this.calculateCartTotal();
            },
            searchProducts: function () {
                var vm = this;
                //alert(this.SearchValue);
                axios.get('https://gopalganjbazar.com/web/api/search-products/' + this.SearchValue)
                    .then(function (response) {
                        // handle success
                        vm.products = response.data.data;
                        // console.log(response.data.data);
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    });
            },
            findCustomer: function () {

                var vm = this;
                //alert(this.SearchValue);
                if(vm.phone.length==11){
                    axios.get('https://gopalganjbazar.com/web/api/shipping/'+vm.phone)
                        .then(function (response) {
                            // handle success
                            //console.log(response.data);
                            if(response.data.shippings!=null){
                                vm.name = response.data.shippings.name;
                                let engArea=response.data.shippings.area.split('(')[0];
                                vm.area = engArea.trim();
                                vm.areaSelected=true;
                                vm.address = response.data.shippings.address ;
                                let location=vm.locations.filter((e) => e.location_name === engArea.trim());
                                vm.delivery_charge=location[0].delivery_charge;
                                vm.calculateCartTotal();
                            }else{
                                vm.name =null;
                                vm.area = null;
                                vm.address = null ;
                                vm.location_id = null ;
                                vm.delivery_charge=0;
                            }
                        })
                        .catch(function (error) {
                            // handle error
                            console.log(error);
                        });
                }else{
                    alert('Phone Number Invalid');
                }
            },
            createOrder() {
                // $(".createOrder")
                // .addClass("disabled");
                // $(".createOrder").append( "<i class='fa fa-spinner fa-spin'></i>" );

                let vm = this;
                let customer_id=$("#customer_id").val();
                $(".loadershow").show();
                if(vm.expectedDeliveryTime){
                  vm.assignedDeliveryTime = vm.expectedDeliveryTime + ' '+ vm.expectedDeliveryStartTime +' - '+ vm.expectedDeliveryEndTime;
                } else {
                  vm.assignedDeliveryTime = '';
                }

                if(customer_id && this.name!=null && this.deliveryManId!=null && this.phone!=null && this.delivery_charge>0 && this.area!=null){

                    @if(Auth::user()->role === 'admin')
                    axios.post('https://gopalganjbazar.com/web/ad/admin-order',
                        {
                            customer_id: customer_id,
                            name: this.name,
                            delivery_man_id: this.deliveryManId,
                            phone: this.phone,
                            sms: this.sms,
                            delivery_charge: this.delivery_charge,
                            area: this.area,
                            area_id: this.location_id,
                            address: this.address,
                            payment_type: this.payment_type,
                            coupon:'ADDISC',
                            discount:this.discount,
                            notes:this.notes,
                            data: this.carts,
                            delivery_time: this.assignedDeliveryTime
                        }, {crossdomain: true})
                    @elseif(Auth::user()->role ==='manager')
                    axios.post('https://gopalganjbazar.com/web/pm/admin-order',
                        {
                            customer_id: customer_id,
                            name: this.name,
                            delivery_man_id: this.deliveryManId,
                            phone: this.phone,
                            sms: this.sms,
                            delivery_charge: this.delivery_charge,
                            area: this.area,
                            area_id: this.location_id,
                            address: this.address,
                            payment_type: this.payment_type,
                            coupon:'ADDISC',
                            discount:this.discount,
                            notes:this.notes,
                            data: this.carts,
                            delivery_time: this.assignedDeliveryTime
                        }, {crossdomain: true})
                    @elseif(Auth::user()->role ==='author')
                    axios.post('https://gopalganjbazar.com/web/au/admin-order',
                        {
                            customer_id: customer_id,
                            name: this.name,
                            delivery_man_id: this.deliveryManId,
                            phone: this.phone,
                            sms: this.sms,
                            delivery_charge: this.delivery_charge,
                            area: this.area,
                            area_id: this.location_id,
                            address: this.address,
                            payment_type: this.payment_type,
                            coupon:'ADDISC',
                            discount:this.discount,
                            notes:this.notes,
                          data: this.carts,
                          delivery_time: this.assignedDeliveryTime
                        }, {crossdomain: true})
                    @endif
                    .then((response) => {
                        console.log(response.data.order_id);
                        $(".loadershow").hide();
                        @if(Auth::user()->role === 'admin')
                        $("#messagearea").append("<div class=\"message\">\n" +
                            "                            <b><i class=\"fa fa-check-circle\" ></i> Success</b> <a target='_blank' href='https://gopalganjbazar.com/web/ad/order/print/"+response.data.order_id+"' class=\"btn btn-xs btn-warning\">BN</a><a target='_blank' href='https://gopalganjbazar.com/web/ad/order/print-en/"+response.data.order_id+"' class=\"btn btn-xs btn-success\">EN</a>  <i class=\"fa fa-close pull-right\"></i><br>\n" +
                            "                            <a target='_blank' href='https://gopalganjbazar.com/web/ad/order/"+response.data.order_id+"'>Order Created Successfully. Order ID: "+response.data.order_id+"</a> </div>");
                        @elseif(Auth::user()->role ==='manager')
                        $("#messagearea").append("<div class=\"message\">\n" +
                            "                            <b><i class=\"fa fa-check-circle\" ></i> Success</b> <a target='_blank' href='https://gopalganjbazar.com/web/pm/order/print/"+response.data.order_id+"' class=\"btn btn-xs btn-warning\">BN</a><a target='_blank' href='https://gopalganjbazar.com/web/ad/order/print-en/"+response.data.order_id+"' class=\"btn btn-xs btn-success\">EN</a>  <i class=\"fa fa-close pull-right\"></i><br>\n" +
                            "                            <a target='_blank' href='https://gopalganjbazar.com/web/pm/order/"+response.data.order_id+"'>Order Created Successfully. Order ID: "+response.data.order_id+"</a> </div>");
                        @elseif(Auth::user()->role ==='author')
                        $("#messagearea").append("<div class=\"message\">\n" +
                            "                            <b><i class=\"fa fa-check-circle\" ></i> Success</b> <a target='_blank' href='https://gopalganjbazar.com/web/pm/order/print/"+response.data.order_id+"' class=\"btn btn-xs btn-warning\">BN</a><a target='_blank' href='https://gopalganjbazar.com/web/ad/order/print-en/"+response.data.order_id+"' class=\"btn btn-xs btn-success\">EN</a>  <i class=\"fa fa-close pull-right\"></i><br>\n" +
                            "                            <a target='_blank' href='https://gopalganjbazar.com/web/au/order/"+response.data.order_id+"'>Order Created Successfully. Order ID: "+response.data.order_id+"</a> </div>");

                        @endif
                        localStorage.removeItem("carts");
                        this.carts = [];
                        this.name= null;
                        this.deliveryManId=null;
                        this.notes=null;
                        this.phone=null;
                        this.delivery_charge=null;
                        this.sum_cart_total=0;
                        this.area=null;
                        this.address=null;
                        this.discount=null;
                        this.deliverySlot=false;
                        this.timeSlots=[],
                        this.expectedDeliveryTime =null;
                        this.expectedDeliveryStartTime =null;
                        ethis.xpectedDeliveryEndTime =null;
                        this.assignedDeliveryTime=null
                        //console.log("order ID" + response.data.order_id);
                    })
                    .catch((response) => {
                        alert('Error Something wrong reload and  Try again.')
                        console.log(response);
                        $(".loadershow").hide();

                    });
                }else{
                    $(".loadershow").hide();
                    alert('Check all field  and  Try again.')
                }
            },
            deliveryLocations: function () {

                var vm = this;
                //alert(this.SearchValue);
                axios.get('https://gopalganjbazar.com/web/api/all-delivery-locations')
                    .then(function (response) {
                        // handle success
                        vm.locations = response.data.locations;

                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    });
            },
            getDeliveryMans: function () {
                var vm = this;
                //alert(this.SearchValue);
                axios.get('https://gopalganjbazar.com/web/api/delivery-mans')
                    .then(function (response) {
                        // handle success
                        vm.deliveryMans = response.data.delivery_mans;
                        console.log(response.data.delivery_mans);
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    });
            }
        }
    });
</script>


</body>
</html>