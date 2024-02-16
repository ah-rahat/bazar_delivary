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
                        <div class="panel-heading">Map Location</div>
                        <div class="panel-body">

                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                                @if(Auth::user()->role === 'admin')
                                    {!! Form::open(['url' => 'ad/map-location/store','class'=>'form-vertical','enctype'=>'multipart/form-data','files'=>true ]) !!}
                                @elseif(Auth::user()->role === 'manager')
                                    {!! Form::open(['url' => 'pm/map-location/store','class'=>'form-vertical','enctype'=>'multipart/form-data','files'=>true ]) !!}
                                @endif

                                {{ csrf_field() }}

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="name" class="col-form-label">Customer Phone <b style="color: red">*</b></label>
                                            <input type="text" class="form-control" name="phone" required="" autofocus="">
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="name" class="col-form-label">Map Location  <b style="color: red">*</b></label>
                                            <input type="text" class="form-control" name="url" required="">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group  mb-0">
                                            <button type="submit" class="btn btn-info  pull-right">
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                {!! Form::close() !!}


                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="panel panel-default simple-panel">
                        <div class="panel-heading">  Location Lists</div>
                        <div class="panel-body">
                            <table id="example" class="table table-striped ">
                                <thead>
                                <tr class="text-uppercase">

                                    <td>Customer Phone</td>
                                    <td>Map URL</td>
                                    <td> </td>

                                </tr>
                                </thead>
                                <tbody>

                                @foreach ($customers  as $customer)
                                    <tr>
                                        <td>{{$customer->phone}}</td>
                                        <td>{{$customer->map_url}}</td>
                                        <td><a href="map-location/delete/{{$customer->id}}" class="btn btn-warning  btn-sm">Delete</a></td>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>


@endsection