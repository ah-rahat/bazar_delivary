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
                        <div class="panel-heading">Vendor Request Lists</div>
                        <div class="panel-body">
                       
                            <div>
                                <table class="table table-striped ">
                                    <thead>
                                    <tr>
                                        <td>#ID</td> 
                                        <td>PHONE</td> 
                                        <td>MESSAGE</td>
                                          <td>Date</td>
                                          <td>Status</td>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($vendor_requests   as $vendor)
  
                                        <tr>
                                         <td>#{{$vendor->id}}</td>
                                          <td>{{$vendor->phone}}</td>
                                              <td>{{$vendor->message}}</td>
                                               <td>  {{ date('M d h:i a', strtotime($vendor->created_at)) }} </td>
                                            <td>
                                                @if($vendor->status == 0)

                                                        <a href="vendor-request/{{$vendor->id}}" class="btn btn-sm btn-success">Done</a>

                                                @else
                                                    <span style="color: #388e3c;background: #c8e6c9;padding: 3px 6px;border-radius: 2px;
border: 1px solid #81c784;">Complete</span>
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
    </div>
     @section('footerjs')
    
    @endsection
@endsection
