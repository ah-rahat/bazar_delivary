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
                        <div class="panel-heading">Active Products List</div>
                        <div class="panel-body">
                            <div>
                                <table id="example" class="table table-striped ">
                                    <thead>
                                    <tr>
                                        {{--<td>SN</td>--}}
                                        <td>name</td>

                                        <td>price</td>
                                        <td>discount</td>
                                        <td>quantity</td>
                                        {{--<td>status</td>--}}
{{--                                        <td>category</td>--}}
{{--                                        <td>S.category</td>--}}

                                        <td>F.Image</td>
                                        <td width="120px"> </td>
                                        {{--<td>gp_image_2</td>--}}
                                        {{--<td>gp_image_3</td>--}}
                                        {{--<td>gp_image_4</td>--}}
                                        {{--<td>user_id</td>--}}
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($products as $product)

                                        <tr>
                                            <td>{{$product->name}}</td>
                                            <td>{{$product->price}}</td>
                                            <td>{{$product->discount}}</td>
                                            <td>{{$product->unit_quantity}} {{$product->unit}}</td>
                                            {{--<td>{{$product->status}}</td>--}}
{{--                                            <td>{{$product->cat_name}}</td>--}}
{{--                                            <td>{{$product->sub_cat_name}}</td>--}}


                                            <td><img src="{{ url('/uploads/products') }}/{{$product->featured_image}}" width="55px"></td>
                                            {{--<td><img src="{{$product->gp_image_1}}" width="55px"></td>--}}
                                            {{--<td><img src="{{$product->gp_image_2}}" width="55px"></td>--}}
                                            {{--<td><img src="{{$product->gp_image_3}}" width="55px"></td>--}}
                                            {{--<td><img src="{{$product->gp_image_4}}" width="55px"></td>--}}
                                            {{--<td>{{$product->user_id}}</td>--}}
                                            <td >
                                                
 <a class="btn-sm btn-warning  pull-right ml10" href="delete-product/{{$product->id}}"><i class="fa fa-trash-o"></i></a>
{{--                                                   <a class="btn-sm btn-success pull-right ml10" href="inactive_update/{{$product->id}}">Active</a>--}}
                                                   <a class="btn-sm btn-success pull-right ml10" target="_blank" href="products/{{$product->id}}">EDIT</a>
                                            
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
