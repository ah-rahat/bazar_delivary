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
                        <div class="panel-heading">Edit  Delivery Boy</div>
                        <div class="panel-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }} <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                                </div>
                            @endif

                            @if(Auth::user()->role === 'admin')
                                {!! Form::open(['url' => 'ad/update-delivery-boy','class'=>'form-horizontal','enctype'=>'multipart/form-data','files'=>true ]) !!}

                            @endif


                            {{ csrf_field() }}

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right mt10">Delivery Boy Name</label>
                                <div class="col-md-6">
                                    <input type="hidden" class="form-control" name="id" value="{{$boy->id}}" required>
                                    <input type="text" class="form-control" name="name" value="{{$boy->name}}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right mt10">Phone</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="phone"  value="{{$boy->phone}}"  required>
                                </div>
                            </div>
                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-right mt10">Status</label>
                                    <div class="col-md-6">
                                        <select class="form-control" name="status">
                                            <option value="1" @if($boy->status ==1) selected @endif>Active</option>
                                            <option value="0" @if($boy->status ==0) selected @endif>InActive</option>
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
            </div>
        </div>
    </div>
@endsection
