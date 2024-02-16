@extends('layouts.app')
@section('content')
    @if(Auth::user()->role === 'admin')
        @include('layouts.admin-sidebar')
    @else
        @include('layouts.shop-sidebar')
    @endif
    <div class="content-area">
        <div class="container-fluid mt30">
            <div class="row justify-content-center">
                <div class="col-md-12 mt30">
                    <div class="panel panel-success">
                        <div class="panel-heading">Inactive Products List</div>
                        <div class="panel-body">
                            <div>
                                <table id="example" class="table table-striped regulatList">
                                    <thead>
                                    <tr>
                                        <td>P.Image</td>
                                        <td>name</td>
                                        <td>Weight</td>
                                        <td>Stock</td>
                                        <td>Sale&nbsp;price</td>
                                        <td></td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($products as $product)
                                        <tr id="{{$product->id}}">
                                            <td><img src="{{ url('/uploads/products') }}/{{$product->featured_image}}" width="55px"></td>
                                            <td><a href="{{ url('/shop/products') }}/{{$product->id}}">
                                                {{$product->name }}
                                                <br>
                                                <small style="font-size: 13px;">{{$product->name_bn }}</small>
                                                </a>
                                            </td>
                                            <td>{{$product->unit_quantity }}{{$product->unit }}</td>
                                            <td>{{$product->stock_quantity }}</td>
                                            <td class="main_price"> &#2547; <span>{{$product->price - $product->discount }}</span>  </td>
                                            <td><a class="btn-sm btn-warning pull-right" target="_blank" href="{{ url('/shop/products') }}/{{$product->id}}"><i class="fa fa-edit"></i></a></td>
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

@endsection
