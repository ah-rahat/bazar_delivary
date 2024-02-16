
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
                    <div class="panel-heading">Edit Coupon  </div>
                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

              
                                       {!! Form::open(['url' => 'ad/update-coupon','class'=>'form-horizontal','enctype'=>'multipart/form-data','files'=>true ]) !!}
                                       
 
                         {{ csrf_field() }}
                           <input type="hidden" value="{{$coupon->id}}" name="id" />
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-right mt10">Coupon Code</label>
                            <div class="col-md-6">
                               <input type="text" class="form-control" name="coupon_code" value="{{$coupon->coupon_code}}"  required="" />
                            </div>
                        </div>
                           <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-right mt10">Coupon Discount Amount</label>
                            <div class="col-md-6">
                               <input type="text" class="form-control" name="coupon_discount" value="{{$coupon->coupon_discount}}"  required="" />
                            </div>
                        </div>
                         
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right mt10">Active From Date</label>
                                <div class="col-md-6">
                                      <div class="input-group date" data-provide="datepicker">
                  <input type="text" class="form-control" name="active_from"  required="" value="{{date('m/d/Y', strtotime($coupon->active_from))}}"/>
                  <div class="input-group-addon">
                      <span class="glyphicon glyphicon-th"></span>
                  </div>
              </div>
                                </div>
                            </div>
                              <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right mt10">Active End Date</label>
                                <div class="col-md-6">
                                      <div class="input-group date" data-provide="datepicker">
                  <input type="text" class="form-control" name="active_until"  value="{{date('m/d/Y', strtotime($coupon->active_until))}}" required=""/>
                  <div class="input-group-addon">
                      <span class="glyphicon glyphicon-th"></span>
                  </div>
              </div>
                                </div>
                            </div>
{{--                            <div class="form-group row">--}}
{{--                                <label for="name" class="col-md-4 col-form-label text-right mt10">Start Time</label>--}}
{{--                                <div class="col-md-6">--}}
{{--                                    <div>--}}
{{--                                        <input type="text" class="form-control" name="start_time" value="{{$coupon->start_time}}"  placeholder="EX: 10:00"/>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="form-group row">--}}
{{--                                <label for="name" class="col-md-4 col-form-label text-right mt10">End Time</label>--}}
{{--                                <div class="col-md-6">--}}
{{--                                    <div>--}}
{{--                                        <input type="text" class="form-control" name="end_time" value="{{$coupon->end_time}}"  placeholder="EX: 20:00"/>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="form-group row">--}}
{{--                                <label for="name" class="col-md-4 col-form-label text-right mt10">Coupon Not valid for products</label>--}}
{{--                                <div class="col-md-6">--}}
{{--                                    <div class="input-group">--}}
{{--                                        <input type="text" class="form-control" name="not_for_valid_products" value="{{$coupon->not_for_valid_products}}"  placeholder="EX: 23,34,3444,333"/>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                              <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right mt10">Status</label>
                                <div class="col-md-6">
                                        <select class="form-control selectpicker" data-live-search="true" name="status" >

                                            <option value="0" @if($coupon->status==0) selected @endif >Active</option>
                                            <option value="1" @if($coupon->status==1) selected @endif>Inactive</option>

                                        </select>
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