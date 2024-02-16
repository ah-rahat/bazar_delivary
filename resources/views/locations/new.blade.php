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
                    <div class="panel-heading">Add Location</div>
                    <div class="panel-body">
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif

                        @if(Auth::user()->role === 'admin')
                        {!! Form::open(['url' =>
                        'ad/add_location','class'=>'form-vertical','enctype'=>'multipart/form-data','files'=>true ]) !!}
                        @elseif(Auth::user()->role === 'manager')
                        {!! Form::open(['url' =>
                        'pm/add_location','class'=>'form-vertical','enctype'=>'multipart/form-data','files'=>true ]) !!}
                        @endif

                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="col-form-label">City name (EN)<b
                                            style="color: red">*</b></label>
                                    <input type="text" class="form-control" name="name" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="col-form-label">City name (BN)<b
                                            style="color: red">*</b></label>
                                    <input type="text" class="form-control" name="name_bn" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="col-form-label">Postcode <b
                                            style="color: red">*</b></label>
                                    <input type="text" class="form-control" name="postcode" required />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="name" class="col-form-label">Start Time <b
                                            style="color: red">*</b></label>
                                    <input type="text" class="form-control" name="start_time" required />
                                    <small>Ex: 10:00 AM</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="name" class="col-form-label">End Time</label>
                                    <input type="text" class="form-control" name="end_time" required />
                                    <small>Ex: 6:00 PM</small>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">

                                    <label for="name" class="col-form-label">Days <b style="color: red">*</b></label>
                                    <label><input type="checkbox" name="day[]" value="Sat" /> Sat</label>
                                    <label><input type="checkbox" name="day[]" value="Sun" /> Sun</label>
                                    <label><input type="checkbox" name="day[]" value="Mon" /> Mon</label>
                                    <label><input type="checkbox" name="day[]" value="Tue" /> Tue</label>
                                    <label><input type="checkbox" name="day[]" value="Wed" /> Wed</label>
                                    <label><input type="checkbox" name="day[]" value="Thu" /> Thu</label>
                                    <label><input type="checkbox" name="day[]" value="Fri" /> Fri</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="col-form-label">Charge <b style="color: red">*</b></label>
                                    <input type="number" class="form-control" name="charge" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="col-form-label">Discount </label>
                                    <input type="number" class="form-control" name="discount"  />
                                </div>
                            </div>
                            {{--                                     <div class="col-md-6">--}}
                            {{--                                    <div class="form-group">--}}
                            {{--                                        <label for="name" class="col-form-label">Minimum Order Amount <b--}}
                            {{--                                                    style="color: red">*</b></label>--}}
                            {{--                                        <input type="number" class="form-control" name="min_order_amount"--}}
                            {{--                                               required />--}}
                            {{--                                    </div>--}}
                            {{--                                </div> --}}
                            <div class="col-md-12">
                                <div class="form-group  mb-0">
                                    <button type="submit" class="btn btn-success">
                                        Add
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