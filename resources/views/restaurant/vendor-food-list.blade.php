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
                        <div class="panel-heading">My Food List</div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table id="example" class="table table-striped regulatList">
                                    <thead>
                                    <tr>
                                        <td>Food Name</td>
                                        <td>Sale price</td>
                                        <td>Discount</td>
                                        <td>Quantity</td>
                                        <td>F.Image</td>
                                        <td>Status</td>
                                        <td width="99px"> </td>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach ($products as $product)
                                        <tr id="{{$product->id}}">
                                            <td>{{$product->name }}
                                                <small>{{$product->name_bn }}</small>
                                            </td>
                                            <td class="main_price"> &#2547;{{$product->price - $product->discount }} </td>
                                            <td> &#2547;{{$product->discount}}  </td>
                                            <td>{{$product->unit_quantity}} {{$product->unit}}</td>
                                            <td><img class="img-thumbnail" src="{{ url('/uploads/products') }}/{{$product->featured_image}}" width="55px"></td>
                                            <td>
                                                @if($product->status ==1)
                                                    Active
                                                @else
                                                    Inactive
                                                @endif
                                            </td>

                                            <td>

                                                <a class="btn-sm btn-warning pull-right" href="foods/{{$product->id}}"><i class="fa fa-edit"></i></a>

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

@section('footerjs')
    <script>

    </script>

@endsection
