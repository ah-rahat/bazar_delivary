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


                <div class="col-md-12 mt10">
                    <div class="panel panel-default simple-panel">
                        <div class="panel-heading">Add New Employee</div>
                        <div class="panel-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }} <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                                </div>
                            @endif

                            @if(Auth::user()->role === 'admin')
                                {!! Form::open(['url' => 'ad/update-employee','class'=>'form-horizontal','enctype'=>'multipart/form-data','files'=>true ]) !!}

                            @endif

                            {{ csrf_field() }}
                                <input type="hidden" class="form-control" name="id" value="{{$emp->id}}" required>
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right mt10">Name</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name" value="{{$emp->name}}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right mt10">Phone</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="phone" value="{{$emp->phone}}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right mt10">address</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="address" value="{{$emp->address}}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right mt10">salary</label>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" name="salary" value="{{$emp->salary}}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right mt10">Hourly Bill</label>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" name="hourly_bill"  value="{{$emp->hourly_bill}}" required>
                                </div>
                            </div>
                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-right mt10">Hourly Bill</label>
                                    <div class="col-md-6">
                                        <select class="form-control" name="status">
                                            <option value="1" @if($emp->status ==1) selected @endif>Active</option>
                                            <option value="0" @if($emp->status ==0) selected @endif>InActive</option>
                                        </select>
                                    </div>
                                </div>

                            <div class="form-group row mb-0">
                                <label   class="col-md-4 col-form-label text-md-right"> </label>
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa  fa-save"></i> &nbsp;Submit
                                    </button>
                                </div>
                            </div>
                            {!! Form::close() !!}

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
