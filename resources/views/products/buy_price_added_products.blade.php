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
                <div class="col-md-12 mt30">
                    <div class="panel panel-success">
                        <div class="panel-heading">Price added but not real stock added Products List</div>
                        <div class="panel-body">
                            <div>
                                <table id="example" class="table table-striped regulatList">
                                    <thead>
                                    <tr>
                                        <td>P.Image</td>
                                        <td>name</td>
                                        <td>Weight</td>
                                        <td>Stock</td>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($products as $product)

                                        <tr id="{{$product->id}}">
                                            <td><img src="{{ url('/uploads/products') }}/{{$product->featured_image}}" width="55px"></td>
                                            <td><a target="_blank" href="products/{{$product->id}}"> {{$product->name }}</a></td>
                                            <td>{{$product->unit_quantity }}{{$product->unit }}</td>
                                            <td>{{$product->stock_quantity }}</td>
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
    </div>

@section('footerjs')
    <script>




    </script>

@endsection
