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

                        <div class="panel-heading">Big buy price Products List
                           </div>
                        <div class="panel-body">
                            <div>

                                                                <table id="example" class="table table-striped ">
                                                                    <thead>
                                                                    <tr>
                                                                        <td>name</td>
                                                                        <td>Total Amount</td>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    @foreach ($products as $product)
                                                                 @if($product->buy_price * $product->stock_quantity > 3000)
                                                                        <tr>
                                                                            <td>{{$product->name}}</td>
                                                                            <td>{{$product->buy_price * $product->stock_quantity}}</td>
                                                                            @if($product->status == 1)
                                                                            <td>Active</td>
                                                                            @else
                                                                                <td>InActive</td>
                                                                                @endif
                                                                            <td >

                                                                                <a class="btn-sm btn-warning pull-right" target="_blank" href="products/{{$product->id}}"><i class="fa fa-edit"></i></a>

                                                                            </td>
                                                                        </tr>
                                                                @endif
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


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>
    <script type="text/javascript">

    </script>
@endsection
