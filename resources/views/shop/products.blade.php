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
                    <div class="panel-heading">Products List</div>
                    <div class="panel-body">
                        <div>
                            <table id="example" class="table table-striped ">
                                <thead>
                                <tr>
                                    <td>ID</td>
                                    <td>Quantity</td>
                                    <td>Name</td>
                                    <td>Price</td>
                                    <td>Discount</td>
                                    <td>F.Image</td>
                                    <td></td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($products as $product)

                                <tr>
                                    <td>
                                        <a style="color: #e91e63;" target="_blank" href="products/{{$product->product_id}}">#{{$product->product_id}}</a>
                                    </td>
                                    <td>{{$product->name}}  <br>
                                        <small style="font-size: 13px;">{{$product->name_bn}}</small>
                                    </td>
                                    <td>{{$product->unit_quantity}} {{$product->unit}}</td>
                                    <td>{{$product->price}}</td>
                                    <td>{{$product->discount}}</td>

                                    {{--<td>{{$product->status}}</td>--}}
<!--                                    <td>{{$product->cat_name}}</td>-->
<!--                                    <td>{{$product->sub_cat_name}}</td>-->

                                    <td><img src="{{ url('/uploads/products') }}/{{$product->featured_image}}" width="55px"></td>
                                    {{--<td><img src="{{$product->gp_image_1}}" width="55px"></td>--}}
                                    {{--<td><img src="{{$product->gp_image_2}}" width="55px"></td>--}}
                                    {{--<td><img src="{{$product->gp_image_3}}" width="55px"></td>--}}
                                    {{--<td><img src="{{$product->gp_image_4}}" width="55px"></td>--}}
                                    {{--<td>{{$product->user_id}}</td>--}}
                                     <td>
                                         <a class="btn-sm btn-warning pull-right" target="_blank" href="products/{{$product->product_id}}"><i class="fa fa-edit"></i></a>
                                    </td>
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
@endsection
