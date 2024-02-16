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
                <div class="panel-heading">Category Lists</div>
                <div class="panel-body">
                    <table  class="table table-striped table-bordered table-responsive inline-tbl">
                        <thead>
                        <tr>
                            {{--<td>SN</td>--}}
                            <th>Category name (EN)</th>
                            <th>Category name (BN)</th>
                            <th>Category Photo</th>
                             <th>Category Banner</th>
                            <th width="60px"></th>
                            <th width="60px"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($categories as $category)
                        <tr>
                            <td>{{$category->cat_name}}</td>
                            <td>{{$category->cat_name_bn}}</td>
                            <td>
                                @if($category->cat_img)
                                    <img height="45px"  src="{{ url('/uploads/cat_images') }}/{{$category->cat_img}}">
                                @endif
                             </td>   
                              <td>
                                @if($category->cat_banner_img)
                                    <img height="45px"  src="{{ url('/uploads/cat_images') }}/{{$category->cat_banner_img}}">
                                @endif
                             </td>
                            <td class="text-center">

                                    <a class="btn btn-warning btn-sm" href="delete-category/{{$category->id}}"><i class="fa fa-trash-o"></i></a>

                            </td>
                            <td class="text-center">
                                @if(Auth::user()->role === 'admin')
                                <a class="btn btn-warning btn-sm" href="category/{{$category->id}}"><i class="fa fa-pencil"></i></a>
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
