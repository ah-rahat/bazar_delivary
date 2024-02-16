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
                        <div class="panel-heading">  Highest Order Lists</div>
                        <div class="panel-body">
                            <div class="table-responsive">
                            <table id="example" class="table table-striped " style="font-size: 14px;">
                                <thead>
                                <tr class="text-uppercase">
                                    <td style="font-size: 13px;">Order Amount</td>
                                    <td style="font-size: 13px;">Customer Name</td>
                                    <td style="font-size: 13px;">Phone</td>
                                    <td style="font-size: 13px;">Area</td> 
                                    <td style="font-size: 13px;">Address</td> 
                                </tr>
                                </thead>
                                <tbody>

                                 @foreach ($users_array  as $array)
                                   <tr>
                                    <td style="color: #ff6f00;">{{$array['amount']}}</td> 
                                  @foreach ($shinning_customers  as $customer)
                                 
                                  @if($customer->phone===$array['phone'])
                                        <td>{{$customer->name}}</td>
                                        <td>{{$array['phone']}}</td>
                                        <td>{{$customer->area}}</td>
                                        <td>{{$customer->address}}</td> 
                                        @break
                                  @endif  
                                  @endforeach
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