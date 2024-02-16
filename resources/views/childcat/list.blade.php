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
                        <div class="panel-heading">Child Category  Lists</div>
                        <div class="panel-body">
                    <table  class="table table-striped table-bordered table-responsive inline-tbl">
                        <thead>
                        <tr>
                            <th>Sub Category name (EN)</th>
                            <th> Sub Category name (BN)</th>
                            <th>Image </th>
                            <th> </th>
                            <th> </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($child_lists as $child_list)
                        <tr>
                            <td>{{$child_list->child_cat_name}}</td>
                            <td>{{$child_list->child_cat_name_bn}}</td>
                            <td>
                                @if($child_list->cat_image)
                                    <img height="45px"  src="{{ url('/uploads/cat_images') }}/{{$child_list->cat_image}}">
                                @endif</td>
                            <td class="text-center">

                                <a class="btn btn-warning btn-sm" href="delete-childcategory/{{$child_list->id}}"><i class="fa fa-trash-o"></i></a>

                            </td>
                            <td class="text-center">
                                @if(Auth::user()->role === 'admin')
                                <a class="btn btn-warning btn-sm" href="child_category/{{$child_list->id}}">
                                    <i class="fa fa-pencil"></i></a>
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
</div>
</div>
@endsection
