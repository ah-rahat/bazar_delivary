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
                        <div class="panel-heading">Restaurant Lists</div>
                        <div class="panel-body">
                    <table  class="table table-striped table-responsive inline-tbl">
                        <thead>
                        <tr>
                            {{--<td>SN</td>--}}
                            <th>Restaurant Name (EN)</th>
                            <th>Restaurant Name (BN)</th>
                             <th>Address   (EN)</th>
                              <th>Address   (BN)</th>
                             <th>Banner</th>
                            <th> </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($restaurants as $restaurant)

                        <tr>
                            <td>{{$restaurant->restaurant_name_en}}</td>
                             <td>{{$restaurant->restaurant_name_bn}}</td>
                              <td>{{$restaurant->address_en}}</td>
                               <td>{{$restaurant->address_bn}}</td>
                            
                             <td>
                                 <img class="img-thumbnail" style="height: 55px !important;"  src="{{ url('/uploads/restaurants') }}/{{$restaurant->image}}">
                           </td>
                            
                            <td class="text-center">
{{--                                @if(Auth::user()->role === 'admin')--}}
                                <a class="btn btn-warning btn-sm" href="{{$restaurant->id}}"><i class="fa fa-pencil"></i></a>
{{--                                @endif--}}
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
