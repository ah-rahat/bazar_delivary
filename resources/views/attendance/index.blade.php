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
                        <div class="panel-heading">Generate Sheet </div>
                        <div class="panel-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                                @if(Auth::user()->role === 'admin')
                                    {!! Form::open(['url' => 'ad/employee-data','class'=>'form-vertical','enctype'=>'multipart/form-data','files'=>true ]) !!}

                                @elseif(Auth::user()->role === 'manager')
                                    {!! Form::open(['url' => 'pm/employee-data','class'=>'form-vertical','enctype'=>'multipart/form-data','files'=>true ]) !!}

                                @endif

                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">Select Employee <b style="color: red">*</b></label>
                                        <select class="form-control selectpicker" data-show-subtext="true"  name="id" data-live-search="true" required>
                                            <option value="">Select Employee</option>
                                            @foreach ($employees as $employee)
                                                <option value="{{ $employee->id }}">{{$employee->name}}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">Year <b style="color: red">*</b></label>
                                        <select class="form-control selectpicker" data-show-subtext="true"  name="year" data-live-search="true" required>
                                            <option value="2022">2022</option>
                                            <option value="2021">2021</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">Month <b style="color: red">*</b></label>

                                        <select class="form-control selectpicker" data-show-subtext="true"  name="month" data-live-search="true" required>
                                            <option value="">Select Month</option>
                                            <option value="1">January</option>
                                            <option value="2">February</option>
                                            <option value="3">March</option>
                                            <option value="4">April</option>
                                            <option value="5">May</option>
                                            <option value="6">June</option>
                                            <option value="7">July</option>
                                            <option value="8">August</option>
                                            <option value="9">September</option>
                                            <option value="10">October</option>
                                            <option value="11">November</option>
                                            <option value="12">December</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group  mb-0">
                                        <button type="submit"  class="btn btn-success">
                                            Generate
                                        </button>
                                    </div>
                                </div>
                            </div>

                            {!! Form::close() !!}

                        </div>
                    </div>
                </div>
{{--                <div class="col-md-12">--}}
{{--                    <div class="panel panel-success">--}}
{{--                        <div class="panel-heading">Entry Attendance </div>--}}
{{--                        <div class="panel-body">--}}
{{--                            <div>--}}
{{--                                <table class="table table-striped ">--}}
{{--                                    <thead>--}}
{{--                                    <tr>--}}
{{--                                        <td class="text-uppercase">Date</td>--}}
{{--                                        <td>Status</td>--}}
{{--                                        <td>Overtime</td>--}}
{{--                                        <td>Late Time</td>--}}
{{--                                        <td>Comments</td>--}}
{{--                                    </tr>--}}
{{--                                    </thead>--}}
{{--                                    <tbody>--}}
{{--                                    <tr>--}}
{{--                                        <td>Date</td>--}}
{{--                                        <td>--}}
{{--                                            <select class="form-control selectpicker"  name="status" >--}}
{{--                                                <option value="">Select</option>--}}
{{--                                                <option value="P">Present</option>--}}
{{--                                                <option value="A">Absent</option>--}}
{{--                                            </select>--}}
{{--                                        </td>--}}
{{--                                        <td> <input type="number" class="form-control w100"></td>--}}
{{--                                        <td> <input type="number" class="form-control w100"></td>--}}
{{--                                        <td><textarea class="form-control h33"></textarea></td>--}}
{{--                                    </tr>--}}
{{--                                    </tbody>--}}
{{--                                </table>--}}





{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div class="right-humberger-menu">

                </div>
            </div>
        </div>
    </div>
<style>
    textarea.form-control.h33 {
        height: 33px !important;
    }
    input.w100{
        width: 150px !important;
    }
</style>
@endsection
