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
                            <div class="panel-heading">Change Password</div>
                            <div class="panel-body">

                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {!! Form::open(['url' => '/update_password','class'=>'form-horizontal','enctype'=>'multipart/form-data','files'=>true ]) !!}
                        {{ csrf_field() }}
          
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-right mt10">New Password</label>
                            <div class="col-md-6">
                               <input type="password" class="form-control" name="new_password" required>
                            </div>
                        </div>
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right mt10">Confirm Password</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="c_password" required>
                                </div>
                            </div>
                             
                        <div class="form-group row mb-0">
                            <label   class="col-md-4 col-form-label text-md-right"> </label>
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Update Password
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
