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
                    <div class="panel-heading"> Location Lists</div>
                    <div class="panel-body">
                        <table id="datatable" class="table table-striped ">
                            <thead>
                                <tr class="text-uppercase">

                                    <td>City Name (EN</td>
                                    <td>City Name (BN)</td>
                                    <td> Start Time </td>
                                    <td> End Time </td>
                                    <td> Day </td>
                                    <td> Charge </td>
                                     <td> Discount </td>
                                    <td> Postcode </td>
                                    {{--                                    <td> Extra Fast Charge </td>--}}
                                    {{--                                    <td> W.S</td>--}}
                                    {{--                                      <td> Min.O Amount</td>--}}
                                    <td> </td>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($locations as $location)
                                <tr>

                                    <td>{{$location->location_name}}</td>
                                    <td>{{$location->location_name_bn}}</td>
                                    <td>{{$location->start_time}}</td>
                                    <td>{{$location->end_time}}</td>
                                    <td>{{$location->days}}</td>
                                    <td>{{$location->delivery_charge}}</td>
                                    <td>{{$location->discount}}</td>
                                    <td>{{$location->postcode}}</td>
                                    {{--                                             <td>{{$location->extra_fast_delivery_charge}}
                                    </td>--}}
                                    {{--                                         <td>{{$location->water_location_serial}}
                                    </td>--}}
                                    {{--                                             <td>{{$location->min_order_amount}}
                                    </td>--}}
                                    <td class="text-center  "><a href="location/{{$location->location_id}}"
                                            class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i></a></td>
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