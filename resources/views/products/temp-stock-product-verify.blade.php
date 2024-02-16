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
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default simple-panel">
                        <div class="panel-heading" style="font-size: 15px;">PRODUCT STOCK <span class="pull-right"
                                                                                                id="old_sales_quantity"
                                                                                                style="font-size: 13px;
color: #AD1457 !important;font-weight: 600;text-transform: uppercase;"> Sales Quantity: <span>!{ totalSale }!</span></span>
                        </div>
                        <div class="panel-body">
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group relative-path">
                                        <div class="input-group custom-search-form">
                                            <input type="text" class="form-control" placeholder="Search Product"
                                                   v-model="SearchValue"
                                                   @keyup.enter="searchProducts">
                                            <span class="input-group-btn">
              <button class="btn btn-default" type="button" @click="searchProducts">
              <span class="glyphicon glyphicon-search"></span>
             </button>
             </span>
                                        </div><!-- /input-group -->

                                    </div>
                                </div>
                                <div class="col-md-12" v-if="products.length > 0">
                                    <div class="table-responsive summary-report plists_show " style="height: 237px;">
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
                                            <tr v-for="(product, index) in products" :id="product.id"
                                                v-bind:class="{ inactive: product.status == 0 }" @click="selectProducts(index,product.id,
                                            product.name + ' '+  product.unit_quantity + ' '+  product.unit)">
                                                <td width="60px">
                                                    <div class="relative">
                                                        <img class="pimg" width="60px"
                                                             :src="'https://gopalganjbazar.com/web/uploads/products/' +product.featured_image"/>

                                                    </div>
                                                </td>
                                                <td>
                                                    <div>!{product.name}! !{product.unit_quantity}!
                                                        !{product.unit}!
                                                    </div>
                                                    <div><small>!{product.name_bn}! !{product.unit_quantity}!
                                                            !{product.unit}!</small></div>
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
                                <div class="col-md-12">
                                    <div class="form-group" style="margin-top: 30px;">
                                        <label for="name" class="col-form-label">Product Name <b
                                                    style="color: red">*</b></label>
                                        <input style=" font-weight: bold;background: #fff;color: #e91e63;" type="text" v-model="productName" readonly class="form-control" id="selected_product" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group ">
                                        <label for="name" class="col-form-label">Expire Date. Y-M-D <b
                                                    style="color: red">*</b></label>
                                        <input type="text" class="form-control input-datepicker" id="date" placeholder="yy-m-d"
                                        />
                                        {{--                                               value="{{date('yy-m-d')}}" />--}}
                                    </div>
                                </div>
                                <input type="hidden" id="product_id"/>
                                <div class="col-md-4">
                                    <div class="form-group ">
                                        <label for="name" class="col-form-label">Stock Quantity <b
                                                    style="color: red">*</b></label>
                                        <input type="number" class="form-control" step="any" id="stock_quantity"/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group ">
                                        <label for="name" class="col-form-label">Total Buy Price <b
                                                    style="color: red">*</b></label>
                                        <input type="number" class="form-control" step="any" id="price"/>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group  mb-0">
                                        <button type="button" class="btn btn-success add_stock_btn">
                                            SUBMIT
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{--                <div class="col-md-12">--}}
                {{--                    <div class="panel panel-success">--}}
                {{--                        <div class="panel-heading">Stock List for:: <span class="productName">!{productName}!</span>--}}
                {{--                        </div>--}}
                {{--                        <div class="panel-body">--}}
                {{--                            <div>--}}
                {{--                                <br>--}}

                {{--                                <table class="table table-striped table-hover">--}}
                {{--                                    <thead>--}}
                {{--                                    <tr>--}}
                {{--                                        <td>STOCK QTY</td>--}}
                {{--                                        <td class="text-center">TOTAL PRICE</td>--}}
                {{--                                        <td>DATE</td>--}}
                {{--                                        <td>CREATED AT</td>--}}
                {{--                                        <td>CREATED BY</td>--}}
                {{--                                    </tr>--}}
                {{--                                    </thead>--}}
                {{--                                    <tbody>--}}
                {{--                                    <tr v-for="(stockList, index) in stockLists"--}}
                {{--                                        @click="openExpireModal(stockList.product_stock_id,stockList.expire_date)">--}}
                {{--                                        <td>!{stockList.quantity}!</td>--}}
                {{--                                        <td>!{stockList.price}!</td>--}}
                {{--                                        <td>!{stockList.expire_date}!</td>--}}
                {{--                                        <td>!{stockList.created_at}!</td>--}}
                {{--                                        <td>!{stockList.name}!</td>--}}
                {{--                                    </tr>--}}


                {{--                                    </tbody>--}}
                {{--                                </table>--}}
                {{--                                <div class="text-right">--}}

                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
                <div class="right-humberger-menu">

                </div>
            </div>
            <div class="">
                <div class="panel summary-report summary">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table stocklising">
                                        <tbody>
                                        <tr>
                                            <th style="border: none; font-size: 14px;border: 1px solid #e8e8e8 !important;"
                                                colspan="9">Purchase Product's List
                                                <span style="color: rgb(233, 30, 99);" class="pull-right">TOTAL BUY: !{temp_products_buy_price}!TK</span>
                                            </th>
                                        </tr>
                                        <tr>
                                            <td class="comment">
                                                Name
                                            </td>
                                            <td class="comment text-center">
                                                Weight
                                            </td>
                                            <td class="comment text-center">
                                                QTY
                                            </td>
                                            <td class="comment text-center">
                                                TOTAL.BUY.P
                                            </td>
                                            <td class="comment text-center">
                                                SINGLE P.NEW.BUY
                                            </td>
                                            <td class="comment text-center">
                                                SALE.P
                                            </td>
                                            <td class="comment">
                                                OLD.Buy.P
                                            </td>
                                            <td class="comment">
                                                Exp.Date
                                            </td>
                                            <td class="comment" style="width: 40px;"></td>
                                        </tr>
                                        <tr v-for="(product, index) in temp_products" :id="product.id" >
                                                        <td class=" taken" style="color: #000;font-size: 14px;">
                                                            !{product.name}!
                                                        </td>
                                                        <td class=" taken  text-center" style="color: #000;font-size: 14px;">
                                                            !{product.unit_quantity}! !{product.unit}!
                                                        </td>
                                                        <td class=" taken  text-center" style="color:  rgb(233, 30, 99);font-size: 14px;">
                                                            !{product.products_temp_stock_quantity}!
                                                        </td>
                                                    <td class=" taken  text-center" style="color:  rgb(233, 30, 99);font-size: 14px;">
                                                        !{product.products_temp_stock_total_buy_price}!TK
                                                        </td>

                                                        <td class=" taken  text-center" style="color:  rgb(233, 30, 99);font-size: 14px;">
                                                            !{Math.floor(product.products_temp_stock_total_buy_price / product.products_temp_stock_quantity)}!

                                                        </td>
                                                        <td class=" taken  text-center" style="color:  rgb(233, 30, 99);font-size: 14px;">
                                                            <div style="color:  rgb(233, 30, 99);">
                                                                !{product.price - product.discount}!TK
                                                            </div>
                                                        </td>
                                                        <td class=" taken  text-center" style="font-size: 14px;">
                                                            <div>
                                                                !{product.buy_price}!TK
                                                            </div>

                                                        </td>
                                            <td class=" taken  text-center" style="font-size: 14px;" title="Y-M-D">
                                                <small>
                                                    !{product.expire_date}!
                                                </small>

                                            </td>

                                                        <td>
                                                            <a title="Approve" class="btn btn-sm btn-success btn-sm" @click="ApproveProduct(product.id,product.products_temp_stock_total_buy_price,product.products_temp_stock_quantity,product.expire_date,product.products_temp_stock_row_id)">Approve</a>
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

            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog" style="max-width: 376px !important;">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-body text-center">
                            <h4 style="color: #e91e63;text-transform: capitalize;font-size: 18px;"
                                id="product_name_title">!{productName}!</h4>
                            <h4 style="color: #545553;text-transform: uppercase;font-size: 14px;">Quantity: <b
                                        style="color: #e91e63;" id="product_Quantity"></b> Total Price: &#2547;<b
                                        id="total_Price" style="color: #e91e63;"></b></h4>
                        </div>
                        <div class="modal-footer" style="border: none; text-align: center;">
                            <button type="button" id="sore_in_stock_btn" class="btn btn-success">SAVE PRODUCT</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
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
    <script type="text/javascript">

        var app = new Vue({
            el: '#myapp',
            delimiters: ['!{', '}!'],
            data: {
                products: [],
                temp_products: [],
                temp_products_buy_price: null,
                SearchValue: null,
                isActive: false,
                stockLists: [],
                product_id: null,
                stock_quantity: null,
                date: null,
                price: null,
                totalSale: 0,
                productName: null,
            },
            created: function () {
              this.purchaseProducts();
            },
            methods: {
                searchProducts: function () {
                    var vm = this;
                    //alert(this.SearchValue);
                    jQuery(".plists tbody tr").removeClass('active');
                    axios.get('https://gopalganjbazar.com/web/api/search-products/' + this.SearchValue)

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
                ApproveProduct: function (product_id,buy_price,quantity,expireDate,products_temp_stock_row_id) {
                    @if(Auth::user()->role === 'admin')
                    axios.get('https://gopalganjbazar.com/web/ad/products/findsales/' + product_id,
                        {
                            data: '_token = <?php echo csrf_token() ?>'
                        })
                    @elseif(Auth::user()->role === 'manager')
                    axios.get('https://gopalganjbazar.com/web/pm/products/findsales/' + product_id,
                        {
                            data: '_token = <?php echo csrf_token() ?>'
                        })
                    @endif
                        .then(function (response) {
                            // handle success
                            console.log(response.data);
                            if (response.data.isinSale.get_total > 0 && response.data.stockLists.length <= 0) {
                                alert('The  product  is  in active  order.Dont add stock');
                            }else{
                                axios.post('https://gopalganjbazar.com/web/api/temp-products-final-update',
                                    {
                                        product_id: product_id,
                                        buy_price: buy_price,
                                        quantity: quantity,
                                        expireDate: expireDate,
                                        products_temp_stock_row_id: products_temp_stock_row_id,
                                        user_id:  {{Auth::user()->id}},
                                    }, {crossdomain: true})
                                    .then((response) => {
                                        //console.log(response);
                                        alert('Data updated successfully.')
                                        location.reload();
                                    })
                                    .catch((response) => {
                                        alert('Something wrong try again.')
                                    });
                            }

                        })
                        .catch(function (error) {
                            // handle error
                            console.log(error);
                        });



                },
                purchaseProducts: function () {
                    var vm = this;
                    axios.get('https://gopalganjbazar.com/web/api/purchase-products/')
                        .then(function (response) {
                            // handle success
                            vm.temp_products = response.data.temp_stocks;
                            vm.temp_products_buy_price = response.data.total_buy_price;
                            console.log(response.data.data);
                        })
                        .catch(function (error) {
                            // handle error
                            console.log(error);
                        });
                },
                openExpireModal: function (product_id, expire_date) {
                    $('#expire_modal').modal('show');
                    let product_name = jQuery(".productName").text();

                    jQuery(".thisproductName").text(product_name);
                    jQuery(".modal_expire_date").text(expire_date);
                    jQuery(".product_id").val(product_id);
                },
                selectProducts: function (index, product_id, productName) {
                    jQuery("tr").removeClass('active');
                    var vm = this;
                    jQuery("#" + product_id).addClass('active');
                    jQuery("#product_id").val(product_id);
                    vm.productName = productName;

                    @if(Auth::user()->role === 'admin')
                    axios.get('https://gopalganjbazar.com/web/ad/products/findsales/' + product_id,
                        {
                            data: '_token = <?php echo csrf_token() ?>'
                        })
                    @elseif(Auth::user()->role === 'manager')
                    axios.get('https://gopalganjbazar.com/web/pm/products/findsales/' + product_id,
                        {
                            data: '_token = <?php echo csrf_token() ?>'
                        })
                    @endif
                        .then(function (response) {
                            // handle success
                            console.log(response.data);
                            vm.product_id = vm.product_id;
                            vm.stockLists = response.data.stockLists;
                            console.log(vm.stockLists.length);
                            if (response.data.isinSale.get_total > 0 && vm.stockLists.length <= 0) {
                                alert('The  product  is  in active  order.Dont add stock');
                            }
                            if (response.data.quantity.get_total > 0) {
                                vm.totalSale = response.data.quantity.get_total;
                            } else {
                                vm.totalSale = 0;
                            }

                            // Vue.filter('formatDateTime', function (value) {
                            //     if (value) {
                            //         return moment(String(value)).format('D MMM  hh:mm A');
                            //     }
                            // });
                        })
                        .catch(function (error) {
                            // handle error
                            console.log(error);
                        });

                },
                updateStock: function () {
                    jQuery("tr").removeClass('active');
                    var vm = this;
                    jQuery("#" + product_id).addClass('active');
                    alert('date' + vm.date);
                    alert('id' + vm.product_id);
                    alert('e' + vm.price);
                    alert(vm.stock_quantity);
                    @if(Auth::user()->role === 'admin')
                    axios.get('https://.com/web/ad/products/stock/' + vm.date + '/' + vm.product_id + '/' + vm.stock_quantity + '/' + vm.price,
                        {
                            data: '_token = <?php echo csrf_token() ?>'
                        })
                    @elseif(Auth::user()->role === 'manager')
                    axios.get('https://.com/web/pm/products/stock/' + vm.date + '/' + vm.product_id + '/' + vm.stock_quantity + '/' + vm.price,
                        {
                            data: '_token = <?php echo csrf_token() ?>'
                        })
                    @endif


                        .then(function (response) {
                            // handle success
                            console.log(response.data);
                            if (response.data.isinSale.get_total > 0) {
                                alert('The  product  is  in active  order.Dont add stock');
                            }
                            if (response.data.quantity.get_total > 0) {
                                vm.totalSale = response.data.quantity.get_total;
                            } else {
                                vm.totalSale = 0;
                            }

                            // Vue.filter('formatDateTime', function (value) {
                            //     if (value) {
                            //         return moment(String(value)).format('D MMM  hh:mm A');
                            //     }
                            // });
                        })
                        .catch(function (error) {
                            // handle error
                            console.log(error);
                        });

                }
            }
        });
    </script>

@endsection

@section('footerjs')

    <style>


        .message b {
            color: #000;
        }

        .message a {
            color: #00897b;
        }

        .message b i {
            color: #00897b;
        }

        .message {
            position: fixed;
            right: 4px;
            bottom: 15px;
            background: rgb(255, 255, 255) none repeat scroll 0% 0%;
            border-radius: 4px;
            box-shadow: #00897b66 0px 1px 3px;
            border-left: 4px solid rgb(0, 137, 123);
            padding: 5px 15px;
        }

        .message a.btn {
            color: #fff;
            margin-left: 5px;
        }

        .table-responsive.summary-report tr {
            cursor: pointer;
        }

        .table-responsive.summary-report tr:hover td {
            background: #AD1457;
            color: #fff;
        }

        .table-responsive.summary-report tr.active td {
            background: #AD1457;
            color: #fff;
        }

        .table-responsive.summary-report tr.active .price, .table-responsive.summary-report tr .price {
            color: #fff !important;
        }

        .inactive {
            color: #AD1457 !important;
            text-transform: capitalize;
        }

        .summary-report.plists_show table tr:hover .pimg {
            opacity: 1 !important;
            border-radius: 4px;
        }

        .simple-panel .form-control {
            min-height: 40px !important;
        }

        .simple-panel .btn {
            padding: 9px 12px
        }

        .summary-report table {
            text-transform: capitalize;
        }

        .table.stocklising tr td.comment {
            font-size: 12px;
        }

        .table.stocklising tr td {
            font-size: 14px;
            padding: 5px !important;
            border: 1px solid #e8e8e891 !important;
            text-transform: capitalize;
        }
    </style>

    <script>

        jQuery('table td').click(function () {
            //alert();
            jQuery(this).addClass("selected");
        });

        jQuery('.input-datepicker').each(function () {
            jQuery(this).datepicker({
                clearDates: true,
                format: 'yyyy-mm-dd',
                todayHighlight: true,
                minDate: new Date(), // = today
                autoclose: true
            });
        });

        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        jQuery(document).ready(function () {
            jQuery('#myModal').on('click', '#sore_in_stock_btn', function () {
                var product_id = jQuery("#product_id").val();
                var date = jQuery("#date").val();
                var price = jQuery("#price").val();
                var stock_quantity = jQuery("#stock_quantity").val();
                if (product_id != '' && date != '' && price != '' && stock_quantity != '') {
                    jQuery.ajax({
                        type: 'GET',
                        @if(Auth::user()->role === 'admin')
                        url: 'https://gopalganjbazar.com/web/ad/products/temp-stock/' + date + '/' + product_id + '/' + stock_quantity + '/' + price,
                        @elseif(Auth::user()->role === 'manager')
                        url: 'https://gopalganjbazar.com/web/pm/products/temp-stock/' + date + '/' + product_id + '/' + stock_quantity + '/' + price,
                        @endif
                        dataType: "json",
                        data: '_token = <?php echo csrf_token() ?>',
                        success: function (res) {
                            console.log(res);

                            $('#myModal').modal('hide');
                            Command: toastr["success"]("Stock Updated Successfully");
                            jQuery('#product_id').selectpicker("refresh");
                            jQuery("#date").val('');
                            jQuery("#price").val('');
                            jQuery("#stock_quantity").val('');
                            location.reload();
                        }
                    });
                } else {
                    alert('Something wrong Try again');
                }
            });
        });

        jQuery('.add_stock_btn').click(function () {

            var product_id = jQuery("#product_id").val();
            var date = jQuery("#date").val();
            var price = jQuery("#price").val();
            var stock_quantity = jQuery("#stock_quantity").val();
            if (product_id != '' && date != '' && price != '' && stock_quantity != '') {
                $("#product_Quantity").text(stock_quantity);
                $("#total_Price").text(price);
                $("#myModal").modal();
            } else {
                alert('Something Missing, Check and try again');
            }

        });
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }

        function updateExpireDate() {
            var product_id = jQuery(".product_id").val();
            var expire_date = jQuery("#expired_date").val();

            if (product_id && expire_date) {
                jQuery.ajax({
                    type: 'GET',
                    @if(Auth::user()->role === 'admin')
                    url: 'https://gopalganjbazar.com/web/ad/products/update-expire-date/' + product_id + '/' + expire_date,
                    @elseif(Auth::user()->role === 'manager')
                    url: 'https://gopalganjbazar.com/web/pm/products/update-expire-date/' + product_id + '/' + expire_date,
                    @endif
                    dataType: "json",
                    data: '_token = <?php echo csrf_token() ?>',
                    success: function (res) {
                        console.log(res);

                        $('#expire_modal').modal('hide');
                        Command: toastr["success"]("Updated Successfully");

                        jQuery(".product_id").val('');
                        jQuery("#expired_date").val('');

                    }
                });
            }

        }

        function calculateTotalSale() {
            var product_id = jQuery("#product_id").val();

            jQuery.ajax({
                type: 'GET',
                url: 'https://gopalganjbazar.com/web/ad/products/findsales/' + product_id,
                dataType: "json",
                data: '_token = <?php echo csrf_token() ?>',
                success: function (res) {
                    console.log(res.quantity.get_total);
                    if (res.quantity.get_total > 0) {
                        jQuery("#old_sales_quantity span").text(res.quantity.get_total);
                    } else {
                        jQuery("#old_sales_quantity span").text(0);
                    }


                }
            });

        }

        jQuery('.input-daterange input').each(function () {
            jQuery(this).datepicker({
                //clearDates: true,
                format: 'dd-mm-yyyy',
                //todayHighlight: true,
                autoclose: true
            });
        });

        // jQuery(window).on('load', function() {
        //     jQuery('#expire_modal').modal('show');
        // });

    </script>

@endsection

