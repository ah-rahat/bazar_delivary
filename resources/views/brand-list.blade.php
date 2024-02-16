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
                <div class="panel-heading">Brand List</div>
                <div class="panel-body">

                <table  class="table table-striped table-bordered table-responsive inline-tbl">
                        <thead>
                        <tr>
                            {{--<td>SN</td>--}}
                            <th>Brand name EN</th>
                            <th>Brand name BN</th>
                            <th>Brand Photo</th>
                            <th width="55px">   </th>
                             <th width="55px">   </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($brands  as $brand)
                        <tr>
                            <td>{{$brand->brand_name}}</td>
                            <td>{{$brand->brand_name_bn}}</td>
                            <td>
                                @if($brand->brand_img)
                                <img height="45px"   src="{{ url('/uploads/brand_images') }}/{{$brand->brand_img}}">
                                    @else

                                    @endif
                            </td>
                             <td class="text-center"><a class="btn btn-danger btn-sm" href="brand/delete/{{$brand->id}}"><i class="fa fa-trash-o"></i></a></td>
                            <td class="text-center"><a class="btn btn-warning btn-sm" href="brand/{{$brand->id}}"><i class="fa fa-pencil"></i></a></td>
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
