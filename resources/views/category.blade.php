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
            <div class="col-md-12 ">

                        <div class="panel panel-default simple-panel">
                            <div class="panel-heading">Create Category</div>
                            <div class="panel-body">

                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        
   @if(Auth::user()->role === 'admin')
           {!! Form::open(['url' => '/ad/create_category','class'=>'form-horizontal','enctype'=>'multipart/form-data','files'=>true ]) !!}
                    
 @elseif(Auth::user()->role === 'manager')                      
        {!! Form::open(['url' => '/pm/create_category','class'=>'form-horizontal','enctype'=>'multipart/form-data','files'=>true ]) !!}
                    
 @endif  

                         {{ csrf_field() }}

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-right mt10">category Name (EN</label>
                            <div class="col-md-6">
                               <input type="text" class="form-control" name="cat_name" required>
                            </div>
                        </div>
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right mt10">category Name (BN)</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="cat_name_bn" required>
                                </div>
                            </div>
                             <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right mt10">category Order</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="order" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right">Category Icon</label>
                                <div class="col-md-6">
                                    <input type="file" name="cat_icon" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right">Category Image</label>
                                <div class="col-md-6">
                                    <input type="file" name="cat_img" >
                                </div>
                            </div>
                              <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right">Category Banner Image</label>
                                <div class="col-md-6">
                                    <input type="file" name="cat_banner_img" >
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
