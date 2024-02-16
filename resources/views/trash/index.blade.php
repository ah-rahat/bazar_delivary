@extends('layouts.app')

@section('content')
    @if(Auth::user()->role === 'admin')
        @include('layouts.admin-sidebar')
    @else
        @include('layouts.other-sidebar')
    @endif
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <div class="content-area">
        <div class="container-fluid mt30">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default simple-panel">
                        <div class="panel-heading">Office Trash </div>
                        <div class="panel-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif


                                {!! Form::open(['url' => 'ad/save_trash','class'=>'form-vertical','enctype'=>'multipart/form-data','files'=>true ]) !!}



                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">Product Name <b style="color: red">*</b></label>
                                        <input type="text" class="form-control" name="name"   required autofocus>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">Quantity  <b style="color: red">*</b></label>
                                        <input type="text" class="form-control" name="quantity"   required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="name" class="col-form-label">Date  <b style="color: red">*</b></label>
                                <div class="input-group date" data-provide="datepicker">
                                    <input type="text" class="form-control" name="date"  required=""/>
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>
                            </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">Type  <b style="color: red">*</b></label>
                                        <select class="form-control  "  name="type" required>
                                            <option value="">Select </option>
                                            <option value="bottle">Bottle</option>
                                            <option value="filter">Filter</option>
                                            <option value="other">Other</option>

                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-12 mt10">
                                    <div class="form-group">
                                        <label class="col-form-label">Description   <b style="color: red">*</b></label>
                                        <textarea  name="description" class="form-control" rows="1"></textarea>
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

                <div class="col-md-12 mt10">
                    <div class="panel panel-success">
                        <div class="panel-heading">Office Trash  List</div>
                        <div class="panel-body">
                            <div>
                                <table id="example" class="table table-striped ">
                                    <thead>
                                    <tr>

                                        <td>Product Name</td>
                                        <td>Quantity</td>
                                        <td>Type</td>
                                        <td>Description</td>
                                        <td>Date</td>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($trashes as $trash)
                                        <tr>
                                            <td>{{$trash->name}}</td>
                                            <td>{{$trash->quantity}}</td>
                                            <td>{{$trash->type}}</td>
                                            <td>{{$trash->description}}</td>
                                            <td>{{$trash->date}}</td>
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
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <style>
        .steps-bar span.selected{
            background: #f273a9;
            color: #fff;
            font-weight: normal;
        }
        .steps-bar span.selected label{
            font-weight: normal;
        }
    </style>


@endsection
