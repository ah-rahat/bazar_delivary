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
                    <div class="panel-heading">Add New Admin User</div>
                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }} <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                            </div>
                        @endif
                        
                       
                      {!! Form::open(['url' => 'ad/save-user','class'=>'form-horizontal','enctype'=>'multipart/form-data','files'=>true ]) !!}
 
                        {{ csrf_field() }}

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-right mt10">Name</label>
                            <div class="col-md-6">
                               <input type="text" class="form-control" name="name" required>
                            </div>
                        </div>
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right mt10">Email</label>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" required >
                                </div>
                            </div>
                            
                               <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right mt10">Phone</label>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" name="phone" >
                                </div>
                            </div>
                              <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right mt10">Password</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password"  required>
                                </div>
                            </div>
                            <input type="hidden" name="role" value="admin">
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right">Role</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="role" required>
                                    <option value="">Select Role</option>
                                    <option value="admin">Admin</option>
                                    <option value="manager">Manager</option>
{{--                                    <option value="vendor">Vendor</option>--}}
{{--                                     <option value="author">Author</option>--}}
{{--                                    <option value="3">Customer</option>--}}
                                    </select>
                                </div>
                            </div>
                        <div class="form-group row mb-0">
                            <label   class="col-md-4 col-form-label text-md-right"> </label>
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                   <i class="fa  fa-save"></i> &nbsp;Add User
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
