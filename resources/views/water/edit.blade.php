@extends('layouts.app')

@section('content')
    @if(Auth::user()->role === 'admin')
        @include('layouts.admin-sidebar')
    @else
        @include('layouts.other-sidebar')
    @endif

    <div class="content-area">
        <div class="container-fluid mt30">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default simple-panel">
                        <div class="panel-heading">New Water Customer </div>
                        <div class="panel-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            @if(Auth::user()->role === 'admin')
                                {!! Form::open(['url' => 'ad/update_water_customer','class'=>'form-vertical','enctype'=>'multipart/form-data','files'=>true ]) !!}
                            @elseif(Auth::user()->role === 'manager')
                                {!! Form::open(['url' => 'pm/update_water_customer','class'=>'form-vertical','enctype'=>'multipart/form-data','files'=>true ]) !!}
                            @endif

                            {{ csrf_field() }}
                                <input type="hidden" class="form-control" name="id"  value="{{$customer->id}}"  required>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">Customer Phone  <b style="color: red">*</b></label>
                                        <input type="text" class="form-control" name="phone" value="{{$customer->phone}}"   required autofocus>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">Customer Name  <b style="color: red">*</b></label>
                                        <input type="text" class="form-control" name="name"  value="{{$customer->name}}"  required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">Customer Area  <b style="color: red">*</b></label>
                                        <select class="form-control selectpicker" data-show-subtext="true"  name="area" data-live-search="true" required>
                                            <option value="">Select Area</option>
                                            @foreach ($areas as $area)
                                                <option   value="{{ $area->id }}" @if($customer->area_id==$area->id) selected @endif >{{$area->location_name}} ({{$area->location_name_bn}})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">Status  <b style="color: red">*</b></label>
                                        <select class="form-control"  name="status" required>

                                                <option   value="1" @if($customer->status==1) selected @endif >Active</option>
                                                <option   value="0" @if($customer->status==0) selected @endif >InActive</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12 mt10">
                                    <div class="form-group">
                                        <label class="col-form-label">Address <b style="color: red">*</b></label>
                                        <textarea  name="address" class="form-control" rows="1">{{$customer->address}}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group  mb-0">
                                        <button type="submit"  class="btn btn-success">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </div>

                            {!! Form::close() !!}

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
