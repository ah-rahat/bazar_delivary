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
                            <div class="panel-heading">Edit Restaurant</div>
                            <div class="panel-body">

                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                  
                  
                       @if(Auth::user()->role === 'admin')
                {!! Form::open(['url' => 'ad/restaurants/update_restaurent','class'=>'form-vertical','enctype'=>'multipart/form-data','files'=>true ]) !!}
                @elseif(Auth::user()->role === 'manager')                      
                {!! Form::open(['url' => 'pm/restaurants/update_restaurent','class'=>'form-vertical','enctype'=>'multipart/form-data','files'=>true ]) !!}
                            @elseif(Auth::user()->role === 'author')
                                {!! Form::open(['url' => 'au/restaurants/update_restaurent','class'=>'form-vertical','enctype'=>'multipart/form-data','files'=>true ]) !!}

                            @endif
  
                      

                         {{ csrf_field() }}
                         
                             <input type="hidden" name="id" value="{{$single->id}}"/>
                            
                               <input type="hidden" name="old_res_img" value="{{$single->image}}"/>
                               
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-right mt10">Restaurant Name (EN)</label>
                            <div class="col-md-6">
                               <input type="text" class="form-control" name="restaurant_name_en" value="{{$single->restaurant_name_en}}" required>
                            </div>
                        </div>
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right mt10">Restaurant Name (BN)</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="restaurant_name_bn" value="{{$single->restaurant_name_bn}}" required>
                                </div>
                            </div>
                             <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right mt10">Address (EN)</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="address_en" value="{{$single->address_en}}" required>
                                </div>
                            </div>
                             <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right mt10">Address (BN)</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="address_bn" value="{{$single->address_bn}}" required>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right">Restaurant Image</label>
                                <div class="col-md-6">
                                 <img src="{{ url('/uploads/restaurants') }}/{{$single->image}}"
                                             height="100px" alt="">
 
                                    <input type="file" name="image" value=""    />
                                </div>
                            </div>
                              <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right">Status</label>
                                <div class="col-md-6">
                                    <select class="form-control selectpicker" name="status"  > 
                                              <option value="1" @if($single->status==1) selected @endif >Active</option>
                                            <option value="0" @if($single->status==0) selected @endif>Inactive</option>
                                    
                                        </select>
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
