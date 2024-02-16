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
                    <div class="panel-heading">Edit Brand</div>
                    <div class="panel-body">

                    @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

@if(Auth::user()->role === 'admin')
       {!! Form::open(['url' => 'ad/update_brand','class'=>'form-horizontal','enctype'=>'multipart/form-data','files'=>true ]) !!}
 @elseif(Auth::user()->role === 'manager')                      
     {!! Form::open(['url' => 'pm/update_brand','class'=>'form-horizontal','enctype'=>'multipart/form-data','files'=>true ]) !!}
 @endif   
                       
                        {{ csrf_field() }}
                            <input type="hidden" class="form-control" name="id" value="{{$brand->id}}">
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label mt10 text-right">Brand Name En</label>
                            <div class="col-md-6">
                               <input type="text" class="form-control" name="brand_name" value="{{$brand->brand_name}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label mt10 text-right">Brand Name BN</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="brand_name_bn" value="{{$brand->brand_name_bn}}">
                            </div>
                        </div>
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right">Brand Image</label>
                                <div class="col-md-6">
                                    <img src="{{ url('/uploads/brand_images') }}/{{$brand->brand_img}}" height="200px" alt="">
                                    <input type="file" name="brand_img">
                                </div>
                            </div>
                        <div class="form-group row mb-0">
                            <label   class="col-md-4 col-form-label text-md-right"> </label>
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Submit
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
