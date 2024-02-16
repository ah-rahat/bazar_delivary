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
                    <div class="panel-heading">Update Location</div>
                    <div class="panel-body">
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif
                        @if(Auth::user()->role === 'admin')
                        {!! Form::open(['url' =>
                        'ad/update_location','class'=>'form-vertical','enctype'=>'multipart/form-data','files'=>true ])
                        !!}
                        @elseif(Auth::user()->role === 'manager')
                        {!! Form::open(['url' =>
                        'pm/update_location','class'=>'form-vertical','enctype'=>'multipart/form-data','files'=>true ])
                        !!}
                        @endif


                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{$location->id}}" />


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="col-form-label">City name (EN)<b
                                            style="color: red">*</b></label>
                                    <input type="text" class="form-control" name="name"
                                        value="{{ $location->location_name }}" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="col-form-label">City name (BN) <b
                                            style="color: red">*</b></label>
                                    <input type="text" class="form-control" name="name_bn"
                                        value="{{ $location->location_name_bn }}" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="col-form-label">Postcode <b
                                            style="color: red">*</b></label>
                                    <input type="text" class="form-control" name="postcode"
                                        value="{{$location->postcode}}" required />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="name" class="col-form-label">Start Time <b
                                            style="color: red">*</b></label>
                                    <input type="text" class="form-control" value="{{ $location->start_time }}"
                                        name="start_time" required />
                                    <small>Ex: 10:00 AM</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="name" class="col-form-label">End Time</label>
                                    <input type="text" class="form-control" value="{{ $location->end_time }}"
                                        name="end_time" required />
                                    <small>Ex: 6:00 PM</small>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">

                                    <label for="name" class="col-form-label">Days <b style="color: red">*</b></label>
                                    <label>
                                        <input @if (in_array('Sat', explode(',', $location->days))) checked @endif
                                        type="checkbox"
                                        name="day[]"
                                        value="Sat"
                                        />
                                        Sat
                                    </label>

                                    <label>
                                        <input @if (in_array('Sun', explode(',', $location->days)))
                                        checked
                                        @endif
                                        type="checkbox"
                                        name="day[]"
                                        value="Sun"
                                        />
                                        Sun
                                    </label>

                                    <label>
                                        <input @if (in_array('Mon', explode(',', $location->days)))
                                        checked
                                        @endif
                                        type="checkbox"
                                        name="day[]"
                                        value="Mon"
                                        />
                                        Mon
                                    </label>
                                    <label>
                                        <input @if (in_array('Tue', explode(',', $location->days)))
                                        checked
                                        @endif
                                        type="checkbox"
                                        name="day[]"
                                        value="Tue"
                                        />
                                        Tue
                                    </label>
                                    <label>
                                        <input @if (in_array('Wed', explode(',', $location->days)))
                                        checked
                                        @endif
                                        type="checkbox"
                                        name="day[]"
                                        value="Wed"
                                        />
                                        Wed
                                    </label>
                                    <label>
                                        <input @if (in_array('Thu', explode(',', $location->days)))
                                        checked
                                        @endif
                                        type="checkbox"
                                        name="day[]"
                                        value="Thu"
                                        />
                                        Thu
                                    </label>
                                    <label>
                                        <input @if (in_array('Fri', explode(',', $location->days)))
                                        checked
                                        @endif
                                        type="checkbox"
                                        name="day[]"
                                        value="Fri"
                                        />
                                        Fri
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="col-form-label">Charge <b style="color: red">*</b></label>
                                    <input type="number" class="form-control" name="charge"
                                        value="{{$location->charge}}" required />
                                </div>
                            </div>
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="col-form-label">Discount</label>
                                    <input type="number" class="form-control" name="discount"
                                        value="{{$location->discount}}" />
                                </div>
                            </div>
                            {{--                                <div class="col-md-3">--}}
                            {{--                                    <div class="form-group">--}}
                            {{--                                        <label for="name" class="col-form-label">Extra Fast  Charge <b--}}
                            {{--                                                    style="color: red">*</b></label>--}}
                            {{--                                        <input type="number" class="form-control" name="extra_fast_delivery_charge"--}}
                            {{--                                               value="{{$location->extra_fast_delivery_charge}}"
                            required />--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}
                            {{--                                     <div class="col-md-3">--}}
                            {{--                                    <div class="form-group">--}}
                            {{--                                        <label for="name" class="col-form-label">Minimum Order Amount <b--}}
                            {{--                                                    style="color: red">*</b></label>--}}
                            {{--                                        <input type="number" class="form-control" value="{{$location->min_order_amount}}"
                            name="min_order_amount"--}}
                            {{--                                               required />--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}
                            {{--                                <div class="col-md-3">--}}
                            {{--                                    <div class="form-group">--}}
                            {{--                                        <label for="name" class="col-form-label">Water Location Index <b--}}
                            {{--                                                    style="color: red">*</b></label>--}}
                            {{--                                        <input type="number" class="form-control" name="water_location_serial"--}}
                            {{--                                               value="{{$location->water_location_serial}}"
                            required />--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}
                            <div class="col-md-12">
                                <div class="form-group  mb-0">
                                    <button type="submit" class="btn btn-success">
                                        Update
                                    </button>
                                </div>
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
@endsection