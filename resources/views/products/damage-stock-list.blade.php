@extends('layouts.app')

@section('content')
    @if(Auth::user()->role === 'admin')
        @include('layouts.admin-sidebar')
    @else
        @include('layouts.other-sidebar')
    @endif
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.21/dist/vue.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.12.0/underscore-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.1/css/font-awesome.css" />
    <div class="content-area" id="myapp">
        <div class="container-fluid mt30">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default simple-panel">
                        <div class="panel-heading">Add New Product In Damage List</div>
                        <div class="panel-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

{{--                            @if(Auth::user()->role === 'admin')--}}
{{--                                {!! Form::open(['url' => 'ad/save_waiting_list','class'=>'form-vertical','enctype'=>'multipart/form-data','files'=>true ]) !!}--}}
{{--                            @elseif(Auth::user()->role === 'manager')--}}
{{--                                {!! Form::open(['url' => 'pm/save_waiting_list','class'=>'form-vertical','enctype'=>'multipart/form-data','files'=>true ]) !!}--}}
{{--                            @endif--}}

{{--                            {{ csrf_field() }}--}}
                            <div class="row">
                                <div class="col-md-12">

{{--                                    <div class="form-group">--}}
{{--                                        <label for="name" class="col-form-label">Product Name  <b style="color: red">*</b></label>--}}
{{--                                        <input type="text" class="form-control" name="product_name"   required autofocus>--}}
{{--                                    </div>--}}
                                    <div class="form-group relative-path">
                                        <input type="text" placeholder="Search Product" v-model="SearchValue"
                                               @keyup.enter="searchProducts" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12" v-if="products.length > 0">
                                    <div class="table-responsive summary-report plists_show " style="height: 237px;">
                                        <table class="table plists" style="text-transform: none !important;">
                                            <thead>
                                            <tr>
                                                <th>Photo</th>
                                                <th>Name</th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="(product, index) in products" :id="product.id"  v-bind:class="{ inactive: product.status == 0 }" @click="selectProducts(index,product.id,
                                            product.name + ' '+  product.unit_quantity + ' '+  product.unit)">
                                                <td width="60px" >
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
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-12" v-if="productName">
                                    <div class="form-group" >
                                   <input type="text" class="form-control" :value="productName" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">Quantity  <b style="color: red">*</b></label>
                                        <input type="text" class="form-control"  v-model="quantity"   required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">Total Buy Price  <b style="color: red">*</b></label>
                                        <input type="text" class="form-control" v-model="total_buy_price"  >
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <div class="form-group  mb-0">
                                        <button type="button" @click="updateProducts()"  class="btn btn-success">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </div>

{{--                            {!! Form::close() !!}--}}

                        </div>
                    </div>
                </div>

                <div class="col-md-12 mt10">
                    <div class="panel panel-success">
                        <div class="panel-heading">Damage Products List <b class="pull-right">Total: {{ $total }}</b></div>
                        <div class="panel-body">
                            <div>
                                <table id="example" class="table table-striped ">
                                    <thead>
                                    <tr>

                                        <td>Name</td>
                                        <td>Quantity</td>
                                        <td>Total Buy Price</td>
                                        <td>Date</td>
                                        <td>Action</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($products as $product)

                                        <tr>

                                            <td>{{$product->name}}  {{$product->unit_quantity}} {{$product->unit}}</td>

                                            <td>{{$product->quantity}}</td>
                                            <td>{{$product->total_price}}</td>
                                            <td>{{$product->created_at}}</td>

                                            <td  class="text-center">

                                                @if(Auth::user()->role === 'admin')
                                                    <a class="btn-sm btn-warning " href="/web/ad/del_damage_list/{{$product->id}}"><i class=" fa fa-trash-o"></i></a>

                                                @elseif(Auth::user()->role === 'manager')

                                                    <a class="btn-sm btn-warning " href="/web/pm/del_damage_list/{{$product->id}}"><i class="fa fa-trash-o"></i></a>

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
                <div class="right-humberger-menu">

                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <style>
        .steps-bar span.selected{
            background: #f273a9;
            color: #fff;
            font-weight: normal;
        }
        .steps-bar span.selected label{
            font-weight: normal;
        }
    </style>
    <script type="text/javascript">

      var app = new Vue({
        el: '#myapp',
        delimiters: ['!{', '}!'],
        data: {
          products: [],
          isActive: false,
          SearchValue: null,
          productName: null,
          product_id: null,
          total_buy_price: null,
          quantity: null,
        },
        methods: {
          updateProducts: function (index, product_id,productName) {
            var vm = this;
            vm.productName = productName;
            //alert(vm.total_buy_price);
              @if(Auth::user()->role === 'admin')
              axios.get('https://gopalganjbazar.com/web/ad/save-damage/' + vm.product_id+'/'+vm.quantity+'/'+vm.total_buy_price,
                @elseif(Auth::user()->role === 'manager')
                axios.get('https://gopalganjbazar.com/web/pm/save-damage/' + vm.product_id+'/'+vm.quantity+'/'+vm.total_buy_price,
                  @endif
              {
                data: '_token = <?php echo csrf_token() ?>'
              })
              .then(function (response) {
                // handle success
                console.log(response.data);
                if(response.data == true){
                  Command: toastr["success"]("Added  Successfully");
                }else{
                  Command: toastr["error"](" Something Wrong");
                }
              })
              .catch(function (error) {
                // handle error
                console.log(error);
              });
          },
          selectProducts: function (index, product_id,productName) {
            jQuery("tr").removeClass('active');
            var vm = this;
            jQuery("#"+product_id).addClass('active');
            jQuery("#product_id").val(product_id);
            vm.productName = productName;
            vm.product_id = product_id;
            console.log('product_id',product_id);
          },
          searchProducts: function () {
            var vm = this;
            //alert(this.SearchValue);
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
        .table-responsive.summary-report tr{
            cursor: pointer;
        }
        .table-responsive.summary-report tr:hover td{
            background: #AD1457;
            color: #fff;
        }
        .table-responsive.summary-report tr.active td{
            background: #AD1457;
            color: #fff;
        }
        .table-responsive.summary-report tr.active .price, .table-responsive.summary-report tr .price{
            color: #fff !important;
        }
        .inactive {
            color: #AD1457 !important;
            text-transform: capitalize;
        }
        .summary-report.plists_show table tr:hover .pimg{
            opacity: 1 !important;
            border-radius: 4px;
        }
    </style>
@endsection
