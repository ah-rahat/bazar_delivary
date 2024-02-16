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

                        <div class="panel-heading">Products List
                            <input style="float: right;
    width: 335px;" v-model="searchData" v-on:keyup.enter="searchProducts()" type="text"
                                   placeholder="Product Name........" class="form-control end"></div>
                        <div class="panel-body">
                            <div>
                                {{--                                <code>--}}
                                {{--                                    !{products}!--}}
                                {{--                                </code>--}}
                                <table class="table table-striped ">
                                    <thead>
                                    <tr>
                                        <td>#ID</td>
                                        <td>Name</td>
                                        <td>Weight</td>
                                        <td style="font-size: 13px;background: #e91e63a3;text-align: center;">Stock.QTY</td>
                                        <td style="font-size: 13px;background: #ffecb3;text-align: center;">Sale.P</td>
                                        <td style="font-size: 13px;background: #c5e1a5; text-align: center;">Buy.P </td>
                                        <td>F.Image</td>
                                        <td width="80px"></td>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <tr v-for="product in products" :key="product.id">
                                        <td><a target="_blank" :href="'products/'+product.id">#!{product.id}!</a></td>
                                        <td>!{product.name}!</td>
                                        <td>!{product.unit_quantity}!!{product.unit}!</td>
                                        <td style="font-size: 13px;background: #e91e63a3;text-align: center;">!{product.stock_quantity}!</td>

                                        <td v-if="product.buy_price > product.price - product.discount" style="font-size: 13px;background: #ffecb3; color: red; font-weight: bold; text-align: center;">!{product.price - product.discount}!</td>

                                            <td v-else style="font-size: 13px;background: #ffecb3; text-align: center;">!{product.price - product.discount}!</td>

                                        <td style="font-size: 13px;background: #c5e1a5; text-align: center;">!{product.buy_price}!</td>
                                        <td>
                                            <img class="img-thumbnail"
                                                 :src="'https://gopalganjbazar.com/web/uploads/products/'+product.featured_image"
                                                 width="55px"></td>

                                        <td>
                                            <a class="btn-sm btn-warning pull-right" target="_blank"
                                               :href="'products/'+product.id"><i class="fa fa-edit"></i></a>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>

                                <ul class="pagination pagination-sm">
                                    {{--                                    <li><a href="#"> <span aria-hidden="true">&laquo;</span></a></li>--}}

                                    <li @click="fetchData(each)" :class="current_page == each ?' active':''"
                                        v-for="each in last_page"><a href="#">!{each}!</a></li>

                                    {{--                                    <li><a href="#"><span aria-hidden="true">&raquo;</span></a></li>--}}
                                </ul>
                                {{--                                <table id="example" class="table table-striped ">--}}
                                {{--                                    <thead>--}}
                                {{--                                    <tr>--}}
                                {{--                                        --}}{{--<td>SN</td>--}}
                                {{--                                        <td>name</td>--}}

                                {{--                                        <td>price</td>--}}
                                {{--                                         <td>discount</td>--}}
                                {{--                                        <td>quantity</td>--}}
                                {{--                                        --}}{{--<td>status</td>--}}
                                {{--                                        <td>category</td>--}}
                                {{--                                        <td>S.category</td>--}}
                                {{--                                      --}}
                                {{--                                        <td>F.Image</td>--}}
                                {{--                                        <td width="80px"> </td>--}}
                                {{--                                        --}}{{--<td>gp_image_2</td>--}}
                                {{--                                        --}}{{--<td>gp_image_3</td>--}}
                                {{--                                        --}}{{--<td>gp_image_4</td>--}}
                                {{--                                        --}}{{--<td>user_id</td>--}}
                                {{--                                    </tr>--}}
                                {{--                                    </thead>--}}
                                {{--                                    <tbody>--}}
                                {{--                                    @foreach ($products as $product)--}}

                                {{--                                        <tr>--}}
                                {{--                                            <td>{{$product->name}}</td>--}}
                                {{--                                            <td>{{$product->price}}</td>--}}
                                {{--                                            <td>{{$product->discount}}</td>--}}
                                {{--                                            <td>{{$product->unit_quantity}} {{$product->unit}}</td> --}}
                                {{--                                            --}}{{--<td>{{$product->status}}</td>--}}
                                {{--                                            <td>{{$product->cat_name}}</td>--}}
                                {{--                                            <td>{{$product->sub_cat_name}}</td>--}}
                                {{--                                            --}}


                                {{--                                            <td><img src="{{ url('/uploads/products') }}/{{$product->featured_image}}" width="55px"></td>--}}
                                {{--                                            --}}{{--<td><img src="{{$product->gp_image_1}}" width="55px"></td>--}}
                                {{--                                            --}}{{--<td><img src="{{$product->gp_image_2}}" width="55px"></td>--}}
                                {{--                                            --}}{{--<td><img src="{{$product->gp_image_3}}" width="55px"></td>--}}
                                {{--                                            --}}{{--<td><img src="{{$product->gp_image_4}}" width="55px"></td>--}}
                                {{--                                            --}}{{--<td>{{$product->user_id}}</td>--}}
                                {{--                                            <td >--}}

                                {{--                                                <a class="btn-sm btn-warning pull-right" target="_blank" href="products/{{$product->id}}"><i class="fa fa-edit"></i></a>--}}

                                {{--                                            </td>--}}
                                {{--                                        </tr>--}}
                                {{--                                    @endforeach--}}
                                {{--                                    </tbody>--}}
                                {{--                                </table>--}}


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
    <script type="text/javascript">

      var app = new Vue({
        el: '#myapp',
        delimiters: ['!{', '}!'],
        data: {
          products: [],
          prev_page_url: null,
          current_page: null,
          last_page: null,
          first_page_url: null,
          next_page_url: null,
          searchData: null,
        },
        created: function () {
          this.getProducts()
        },
        methods: {
          getProducts: function () {
            var vm = this;
            //alert(this.SearchValue);

            axios.get('https://gopalganjbazar.com/web/api/active-realstock-product-lists')
              .then(function (response) {
                // handle success
                vm.products = response.data.products.data;
                vm.next_page_url = response.data.products.next_page_url;
                vm.last_page = response.data.products.last_page;
                vm.current_page = response.data.products.current_page;
                vm.first_page_url = response.data.products.first_page_url;
                // console.log(response.data.data);
              })
              .catch(function (error) {
                // handle error
                // console.log(error);
              });
          },
          fetchData: function (page_number) {
            var vm = this;

            axios.get("https://gopalganjbazar.com/web/api/active-realstock-product-lists?page=" + page_number)
              .then(function (response) {
                // handle success

                vm.products = response.data.products.data;
                vm.next_page_url = response.data.products.next_page_url;
                vm.current_page = response.data.products.current_page;
                vm.last_page = response.data.products.last_page;
                vm.first_page_url = response.data.products.first_page_url;
                // console.log(response.data.data);
              })
              .catch(function (error) {
                alert('Something  wrong  try again.')
                // handle error
                // console.log(error);
              });
          },
          searchProducts: function () {
            var vm = this;
            axios.get('https://gopalganjbazar.com/web/api/active-realstock-product-lists?data=' + this.searchData)

              .then(function (response) {
                // handle success
                vm.products = response.data.products.data;
                vm.next_page_url = response.data.products.next_page_url;
                vm.current_page = response.data.products.current_page;
                vm.last_page = response.data.products.last_page;
                vm.first_page_url = response.data.products.first_page_url;
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
