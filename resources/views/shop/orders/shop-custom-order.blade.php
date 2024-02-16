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
                                                <div class="area" v-for="(getAre,index)  in getSearchAreaList" @click="areaAssign(getAre.delivery_charge,getAre.location_name+ '('+getAre.location_name_bn+')',getAre.min_order_amount)" ><i aria-hidden="true" class="fa fa-map-marker"></i> !{getAre.location_name}! (!{getAre.location_name_bn}!)</div>
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
            notes: null,
            name:null,
            deliveryManId:null,
            payment_type:2,
            phone: null,
            sms:0,
            area: null,
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
        },
        watch: {
            area: function() {
                let vm=this;
                console.log(vm.area)
                let getSearchAreaList=vm.locations.filter(function(x) {
                    return x.location_name.toLowerCase().indexOf(vm.area.toLowerCase()) > -1;
                });
                vm.getSearchAreaList=getSearchAreaList;
                //console.log(getSearchAreaList);
            }
        },
        // updated: function(){
        //     this.$nextTick(function(){ $('.selectpicker').selectpicker('refresh'); });
        // },
        created: function () {
            //this.loadApiData();
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
            removeArea: function () {
                let vm=this;
                vm.areaSelected=false;
                vm.area='';
            },
            areaAssign: function (delivery_charge,delivery_area,min_order_amount) {
                let vm=this;
                vm.delivery_charge=delivery_charge;
                vm.area=delivery_area;
                vm.min_order_amount=min_order_amount;
                vm.areaSelected=true;

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
                console.log(ifFind.length);

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
                axios.get('https://gopalganjbazar.com/web/api/shop/admin-search-products/' + this.SearchValue)
                    .then(function (response) {
                        // handle success
                        vm.products = response.data.data;
                        console.log(response.data.data);
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
                    axios.get('https://gopalganjbazar.com/web/api/shop/shipping/'+vm.phone)
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
                if(customer_id && this.name!=null && this.deliveryManId!=null && this.phone!=null && this.delivery_charge>0 && this.area!=null){


                    axios.post('https://gopalganjbazar.com/web/shop/create-shop-order',
                        {
                            customer_id: customer_id,
                            name: this.name,
                            delivery_man_id: this.deliveryManId,
                            phone: this.phone,
                            sms: this.sms,
                            delivery_charge: this.delivery_charge,
                            area: this.area,
                            address: this.address,
                            payment_type: this.payment_type,
                            coupon:'ADDISC',
                            discount:this.discount,
                            notes:this.notes,
                            data: this.carts
                        }, {crossdomain: true})
                    .then((response) => {
                        console.log(response);
                        $(".loadershow").hide();

                        $("#messagearea").append("<div class=\"message\">\n" +
                            "                            <b><i class=\"fa fa-check-circle\" ></i> Success</b> <a target='_blank' href='https://gopalganjbazar.com/web/ad/order/print/"+response.data.order_id+"' class=\"btn btn-xs btn-warning\">BN</a><a target='_blank' href='https://gopalganjbazar.com/web/ad/order/print-en/"+response.data.order_id+"' class=\"btn btn-xs btn-success\">EN</a>  <i class=\"fa fa-close pull-right\"></i><br>\n" +
                            "                            <a target='_blank' href='https://gopalganjbazar.com/web/shop/order/"+response.data.order_id+"'>Order Created Successfully. Order ID: "+response.data.order_id+"</a> </div>");

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
                        console.log("order ID" + response.data.order_id);

                    }).catch((response) => {
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
                        console.log(response.data.locations);
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