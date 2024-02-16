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
            <div class="col-md-12">

                <div class="panel panel-default simple-panel">
                    <div class="panel-heading">Sub Category Lists</div>
                    <div class="panel-body">
                        <table class="table table-striped table-responsive inline-tbl">
                            <thead>
                                <tr>
                                    {{--<td>SN</td>--}}
                                    <th>Sub Category name (EN)</th>
                                    <th>Sub Category name (BN)</th>
                                    <th>Image</th>
                                    <th>Banner</th>
                                    <th> </th>
                                    <th> </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sub_categories as $sub_category)

                                <tr>
                                    <td>{{$sub_category->sub_cat_name}}</td>
                                    <td>{{$sub_category->sub_cat_name_bn}}</td>
                                    <td>
                                        @if($sub_category->cat_image)
                                        <img height="45px"
                                            src="{{ url('/uploads/cat_images') }}/{{$sub_category->cat_image}}">
                                        @endif
                                    </td>
                                    <td>
                                        @if($sub_category->banner)
                                        <img height="45px"
                                            src="{{ url('/uploads/cat_images') }}/{{$sub_category->banner}}">
                                        @endif
                                    </td>
                                    <td class="text-center">

                                        <a class="btn btn-warning btn-sm"
                                            href="delete-subcategory/{{$sub_category->id}}"><i
                                                class="fa fa-trash-o"></i></a>

                                    </td>
                                    <td class="text-center"><a class="btn btn-warning btn-sm"
                                            href="sub_category/{{$sub_category->id}}"><i class="fa fa-pencil"></i></a>
                                    </td>

                                    <!--<a href="sub_category/{{$sub_category->id}}">Edit</a>-->

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
@endsection