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
                        <div class="panel-heading">  Product Request Lists</div>
                        <div class="panel-body">
                            <table  class="table table-striped ">
                                <thead>
                                <tr class="text-uppercase">
                                    <td>#</td>
                                    <td>Phone Number</td> 
                                  
                                    <td>Products</td>
                                      <td>Date</td> 
                                    <td></td>
                                </tr>
                                </thead>
                                <tbody>

                                 @foreach ($requests  as $request)
                                     <tr>
                                         <td class="bolder">#{{$request->id}}</td>
                                           <td>{{$request->phone}}</td>
                                         <td>{{$request->name}}</td>
                                         <td>
                                             {{ date('M d - h:i a', strtotime($request->created_at)) }}
                                         </td>
                                         
                                         <td class="text-center  ">
                                                @if($request->status==0)
                                                @if(Auth::user()->role === 'admin')
                                                <a   href="request/{{$request->id}}" class="btn btn-success btn-sm">Pending</a>
                                                
                                                @elseif(Auth::user()->role === 'manager')                      
                                                <a   href="request/{{$request->id}}" class="btn btn-success btn-sm">Pending</a>
                                                
                                                @endif   

                                               @else
                                          <span class="badge badge-info">Checked</span>
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