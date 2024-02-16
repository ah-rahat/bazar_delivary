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
                    <div class="panel-heading">Add New Banner</div>
                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }} <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                            </div>
                        @endif
                        
                        @if(Auth::user()->role === 'admin')
                      {!! Form::open(['url' => 'ad/create-banner','class'=>'form-horizontal','enctype'=>'multipart/form-data','files'=>true ]) !!}
 @elseif(Auth::user()->role === 'manager')                      
                {!! Form::open(['url' => 'pm/create-banner','class'=>'form-horizontal','enctype'=>'multipart/form-data','files'=>true ]) !!}
 @endif   

                        
                        {{ csrf_field() }}

                       
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right mt10">Banner For</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="type" required>
                                     <option value="">Select Banner Type</option>
                                    <option value="1">Slider Image</option>
                                     <option value="2">Small Home Banner</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right mt10">Banner Link</label>
                                <div class="col-md-6">
                                   <input type="text" class="form-control" name="link" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right">Banner Image</label>
                                <div class="col-md-6">
                                    <input type="file" name="banner_img" required=""  />
                                    <small class="help-text">Note: Slider Banner Image  width 1300px + Height 325px,<br /> Small Home Banner image width 800px Height 250px.</small>
                                </div>
                            </div>
                        <div class="form-group row mb-0">
                            <label   class="col-md-4 col-form-label text-md-right"> </label>
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                   <i class="fa  fa-save"></i> &nbsp;Add Banner
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
