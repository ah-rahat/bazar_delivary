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
                            {!! Form::open(['url' => 'ad/save-employee','class'=>'form-horizontal','enctype'=>'multipart/form-data','files'=>true ]) !!}

                        @endif

                        {{ csrf_field() }}

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-right mt10">Name</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-right mt10">Phone</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="phone" required>
                            </div>
                        </div>
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right mt10">address</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="address" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right mt10">salary</label>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" name="salary" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right mt10">Hourly Bill</label>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" name="hourly_bill" required>
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

                <div class="panel panel-success">
                    <div class="panel-heading">Employee List</div>
                    <div class="panel-body">
                        <div>
                            <table id="example" class="table table-striped ">
                                <thead>
                                <tr>
                                    <td>Name</td>
                                    <td>Salary</td>
                                    <td>Overtime BIll</td>
                                    <td>Status</td>
                                    <td></td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($employees as $employee)
                                <tr>
                                    <td>{{$employee->name}}</td>
                                    <td>{{$employee->salary}}</td>
                                    <td>{{$employee->hourly_bill}}</td>
                                    <td>
                                        @if($employee->status==1)
                                            <span style="color: rgb(56, 142, 60);
background: rgb(200, 230, 201) none repeat scroll 0% 0%;
padding: 3px 6px;
border-radius: 2px;
border: 1px solid rgb(129, 199, 132);"> Active</span>
                                        @elseif($employee->status==0)
                                            <span style="background:#feedef;color: #ef2f45;padding: 3px 6px;border: 1px solid #ef9a9a;border-radius: 2px;"> Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-center  "><a style="background:#fff9c4;color: #fbc02d;padding: 3px 6px;border: 1px solid #8080801c;border-radius: 2px;"   href="edit-employee/{{$employee->id}}" class="btn btn-sm"><i class="fa fa-edit"></i></a></td>
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
