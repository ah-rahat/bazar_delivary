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
                    <div class="panel-heading">Add New User</div>
                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }} <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                            </div>
                        @endif
                        
                       
                      {!! Form::open(['url' => 'ad/users/update-user','class'=>'form-horizontal','enctype'=>'multipart/form-data','files'=>true ]) !!}
 
                        {{ csrf_field() }}
                      <input type="hidden"  name="id" value="{{$user->id}}" >
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-right mt10">Name</label>
                            <div class="col-md-6">
                               <input type="text" class="form-control" name="name" value="{{$user->name}}" required>
                            </div>
                        </div>
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right mt10">Email</label>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email"  value="{{$user->email}}" required>
                                </div>
                            </div>
                            
                               <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right mt10">Phone</label>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" name="phone"  value="{{$user->phone}}" required>
                                </div>
                            </div>
                              <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right mt10">Password</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password"   >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right">Role</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="role" required>
                                    <option value="">Select Role</option>
                                    <option @if($user->role=='admin') selected @endif value="admin">Admin</option>
                                    <option @if($user->role=='manager') selected @endif value="manager">Manager</option>
{{--                                    <option @if($user->role=='vendor') selected @endif value="vendor">Vendor</option>--}}
{{--                                    <option @if($user->role=='author') selected @endif value="author">Author</option>--}}
{{--                                    <option @if($user->role=='3') selected @endif value="3">Customer</option>--}}

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
