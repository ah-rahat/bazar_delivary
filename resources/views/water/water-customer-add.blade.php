@extends('layouts.app')

@section('content')
    @if(Auth::user()->role === 'admin')
        @include('layouts.admin-sidebar')
    @else
        @include('layouts.other-sidebar')
    @endif
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <div class="content-area">
        <div class="container-fluid mt30">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default simple-panel">
                        <div class="panel-heading">New Water Customer <a href="lists/print" target="_blank" class="btn btn-sm btn-info pull-right">PRINT CUSTOMERS</a></div>
                        <div class="panel-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            @if(Auth::user()->role != 'author')
                                @if(Auth::user()->role === 'admin')
                                    {!! Form::open(['url' => 'ad/save_water_customer','class'=>'form-vertical','enctype'=>'multipart/form-data','files'=>true ]) !!}
                                @elseif(Auth::user()->role === 'manager')
                                    {!! Form::open(['url' => 'pm/save_water_customer','class'=>'form-vertical','enctype'=>'multipart/form-data','files'=>true ]) !!}
                                @endif

                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="name" class="col-form-label">Customer Phone <b
                                                        style="color: red">*</b></label>
                                            <input type="text" class="form-control" name="phone" required autofocus>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="name" class="col-form-label">Customer Name <b
                                                        style="color: red">*</b></label>
                                            <input type="text" class="form-control" name="name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="name" class="col-form-label">Customer Area <b
                                                        style="color: red">*</b></label>
                                            <select class="form-control  " name="area" required>
                                                <option value="">Select Area</option>
                                                @foreach ($areas as $area)
                                                    <option value="{{ $area->id }}">{{$area->location_name}}
                                                        ({{$area->location_name_bn}})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-md-12 mt10">
                                        <div class="form-group">
                                            <label class="col-form-label">Address <b style="color: red">*</b></label>
                                            <textarea name="address" class="form-control" rows="1"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group  mb-0">
                                            <button type="submit" class="btn btn-success">
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                {!! Form::close() !!}

                            @endif

                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel" style="margin-bottom:   0px;">
                        <div class="panel-body" style="padding:  7px 15px !important;">
                            <div style="color: #7cb342;
text-transform: uppercase;font-weight: 600;font-size: 13px; ">
                                <span class="pull-left" style="font-size: 12px;">Total Jars:  <b
                                            style="font-weight: 800;font-size: 12px;"> {{$total_jars}} PCS</b></span>
                                <span class="pull-right" style="font-size: 12px;">Total Filters:  <b
                                            style="font-weight: 800;font-size: 12px;"> {{$total_filters}} PCS</b></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 ">
                    <div class="panel" style="margin-bottom:   0px;">
                        <div class="panel-body" style="padding:  7px 15px !important;">
                            <div style="color: #7cb342;
text-transform: uppercase;font-weight: 600;font-size: 13px; ">
                                <span class="pull-left" style="color: #e91e63;font-size: 12px;">Filter's  Outside:  <b
                                            style="font-weight: 800;font-size: 12px;"> {{$filters}} PCS</b></span>
                                <span class="pull-right" style="color: #e91e63;font-size: 12px;">Jar's Outside:  <b
                                            style="font-weight: 800;font-size: 12px;"> {{$jar_outside}} PCS</b></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mt10">
                    <div class="panel panel-success">
                        <div class="panel-heading">Customers List</div>
                        <div class="panel-body">
                            <div>
                                <table id="example" class="table table-striped ">
                                    <thead>
                                    <tr>

                                        <td>ID</td>
                                        <td>Name</td>
                                        <td>Phone</td>
                                        <td>Area</td>
                                        <td>Address</td>
                                        <td></td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($customers as $customer)

                                        <tr>
                                            <td>#{{$customer->id}}</td>
                                            <td>

                                                @if(Auth::user()->role === 'admin')
                                                    <a style="color: #4caf50 !important"
                                                       href="/web/ad/water_customer/{{$customer->id}}">
                                                        {{$customer->name}}<i class="fa fa-pencil"></i></a>
                                                @elseif(Auth::user()->role === 'manager')
                                                    <a style="color: #4caf50 !important"
                                                       href="/web/pm/water_customer/{{$customer->id}}">
                                                        {{$customer->name}}<i class="fa fa-pencil"></i></a>
                                                @endif


                                            </td>
                                            <td>{{$customer->phone}}</td>
                                            <td>
                                                @foreach($areas as $area)
                                                    @if($area->id==$customer->area_id)
                                                        {{$area->location_name}} (
                                                        <small>{{$area->location_name_bn}}</small>)
                                                    @endif
                                                @endforeach

                                            </td>
                                            <td>{{$customer->address}}</td>

                                            <td>

                                                @if(Auth::user()->role === 'admin')
                                                    <a class="btn-sm btn-warning pull-right"
                                                       href="/web/ad/waters/{{$customer->id}}"><i class="fa fa-eye"></i></a>

                                                @elseif(Auth::user()->role === 'manager')

                                                    <a class="btn-sm btn-warning pull-right"
                                                       href="/web/pm/waters/{{$customer->id}}"><i class="fa fa-eye"></i></a>
                                                @elseif(Auth::user()->role === 'author')

                                                    <a class="btn-sm btn-warning pull-right"
                                                       href="/web/au/waters/{{$customer->id}}"><i class="fa fa-eye"></i></a>

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
                <div class="right-humberger-menu">

                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>
    <style>
        .steps-bar span.selected {
            background: #f273a9;
            color: #fff;
            font-weight: normal;
        }

        .steps-bar span.selected label {
            font-weight: normal;
        }
    </style>


@endsection
