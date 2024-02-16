@extends('layouts.app')
@section('content')
    @include('layouts.admin-sidebar')
<div class="content-area" id="apps">
    <div class="container-fluid mt30">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="panel panel-default simple-panel">
                    <div class="panel-heading">
                        Order ID:
                        <span class="orange-color" >
							#{{ $order_custumer->order_id }}
                            <input id="order_id" type="hidden" name="" value="{{$order_custumer->order_id}}" />
						</span>
                        TRN ID:
                        <span class="orange-color">
							{{ $order_custumer->transaction_number }}
						</span>

                    </div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>

                        @endif

                                {!! Form::open(['url' => 'shop/order/custom_product_add','class'=>'form-vertical','enctype'=>'multipart/form-data','files'=>true ]) !!}

                            {{ csrf_field() }}
                        <input type="hidden"  name="id" value="{{$order_custumer->order_id}}" />
                        <input type="hidden"  name="customer_id" value="{{$order_custumer->customer_id}}" />
                        <table id="order_products" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <td>
                                </td>
                                <td>
                                    Product Name
                                </td>
                                <td class="text-center">
                                    Photo
                                </td>
                                <td class="text-center">
                                    Unit Price
                                </td>
                                <td class="text-center">
                                    Order Quantity
                                </td>

                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(cartData, index) in  cartsData" >
                                <td>

                                    <input type="hidden" :value="cartData.product_id" name="product_id[]" />
                                </td>
                                <td>
                                    !{cartData.product_name}!  !{cartData.quantity}! !{cartData.unit}!
                                </td>
                                <td>
                                    <img :src="'https://gopalganjbazar.com/web/uploads/products/' +cartData.product_image"
                                         width="55px">
                                </td>
                                <td>
                                    !{cartData.price}!
                                </td>
                                <td>
                                    <input :id="cartData.product_id" onkeydown="return false" class="form-control quantity" name="quantity[]" type="number" min="1" :max="cartData.stock_quantity" @keyup="MatchQuantiry(cartData.product_id)" @change="MatchQuantiry(cartData.product_id)" value="1" width="35px">
                                </td>
                            </tr>

                            <tr>
                                <td colspan="4">
                                    <input type="text" name="delivery_dicsount" placeholder="Customer Discount" class="form-control" />
                                </td>
                                <td colspan="2">
                                    @if($order_custumer->active_status==0)
                                        <button type="submit" class="btn btn-primary btn-block">
                                            Submit
                                        </button>
                                    @elseif($order_custumer->active_status==1)
                                        <button type="submit" class="btn btn-primary btn-block">
                                            Submit
                                        </button>
                                    @elseif($order_custumer->active_status==2)
                                        <button type="submit" class="btn btn-primary btn-block">
                                            Submit
                                        </button>
                                    @endif


                                </td>
                            </tr>
                            <tr>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="panel panel-default simple-panel">
                    <table class="table table-striped table-bordered">
                        <thead>

                        <tr>
                            <td colspan="6">

                                <input type="text"  v-model="SearchValue"
                                       @keyup.enter="searchProducts" class="form-control" id="searchKey" placeholder="Search Product"/>
                            </td>
                        </tr>

                        </thead>
                        <tbody class="show_lists">
                        <tr v-for="(product, index) in  products" :id="'row_'+product.id" class="toy">
                            <td class="text-center">
                                <input type="hidden" class="discount_price" :value="product.price - product.discount">
                                <img :src="'https://gopalganjbazar.com/web/uploads/products/' +product.featured_image"
                                     width="40px"></td>
                            <td class="p_name_bn" style="font-size: 13px;">!{product.name_bn}! !{product.unit_quantity}!!{product.unit}!</td>
                            <td class="product_price">&#x9f3;!{product.price - product.discount}!</td><td class="text-center" width="30px">
                                <button v-if="product.stock_quantity > 0" @click="createCarts(index,product.id)" type="button" class="btn btn-primary btn-sm addbutton"><i class="fa fa-plus-square-o"></i> ADD</button>
                            </td>
                        </tr>


                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.20/lodash.min.js">
</script>

<script src="https://cdn.jsdelivr.net/npm/vue@2.5.21/dist/vue.js">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js">
</script>
<script type="text/javascript">

    var app = new Vue({
        el: '#apps',
        delimiters: ['!{', '}!'],
        data: {
            products: [],
            cartsData: [],
            SearchValue: null
        },
        created: function () {

        },
        methods: {
            MatchQuantiry: function (product_id) {
                let vm = this;
             let qty = $('#'+product_id).val();
                var max = $('#'+product_id).attr('max');
                console.log(max);

            },
            createCarts: function (index, product_id) {

                let vm = this;

                var  ifFind= vm.cartsData.filter(function (obj) {
                    return obj.product_id === product_id;
                });
                console.log(ifFind.length);

                if(ifFind.length == 0){
                    if (vm.cartsData == null)
                        vm.cartsData = [];
                    let price = (this.products[index].price - this.products[index].discount);
                    //console.log(price);

                    vm.cartsData.push({
                        'product_id': this.products[index].id,
                        'product_name': this.products[index].name,
                        'product_name_bn': this.products[index].name_bn,
                        'product_image': this.products[index].featured_image,
                        'price': price,
                        'quantity': this.products[index].unit_quantity,
                        'stock_quantity': this.products[index].stock_quantity,
                        'unit': this.products[index].unit
                    });

                }else{
                    alert('This Product  is Already In  your Cart');
                }

            },
            searchProducts: function () {
                var vm = this;
                //alert(this.SearchValue);
                axios.get('https://gopalganjbazar.com/web/api/shop/search-products/' + this.SearchValue)
                    .then(function (response) {
                        // handle success
                        vm.products = response.data.data;
                        console.log(response.data.data);
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