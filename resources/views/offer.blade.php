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
                    <div class="panel-heading">Edit Offer Image</div>
                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
 
                       {!! Form::open(['url' => 'ad/update-offer','class'=>'form-horizontal','enctype'=>'multipart/form-data','files'=>true ]) !!}
                       
                             
                       
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right mt10">Status</label>
                                <div class="col-md-6">
                                      <select class="form-control" name="status">
                                      <option value="1">Active</option>
                                      <option value="0">Inactive</option> 
                                      </select>
                                </div>
                            </div>
                             <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right mt10">Background Color Code</label>
                                <div class="col-md-6">
                                      <input type="text" value="{{$offer->color}}" class="form-control" placeholder="Background Color Code" name="color" required="" />
                                </div>
                            </div>
                              <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right mt10">Url</label>
                                <div class="col-md-6">
                                      <input type="text" value="{{$offer->url}}" class="form-control" placeholder="Visit Url" name="url"  />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right">Offer Image</label>
                                <div class="col-md-6">
                                    @if($offer->offer_image)
                                    <img src="{{ url('/uploads/offer_image') }}/{{$offer->offer_image}}" width="200px" class="img-thumbnail" alt="">
                                    <br>
                                    @endif
                                     <input type="hidden" name="old_image" value="{{$offer->offer_image}}" />
                                    <input type="file" name="popup_img"  />
                                </div>
                            </div>
                            
                        <div class="form-group row mb-0">
                            <label   class="col-md-4 col-form-label text-md-right"> </label>
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Update
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
