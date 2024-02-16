@extends('layouts.app')

@section('content')
      @if(Auth::user()->role === 'admin')
    @include('layouts.admin-sidebar')
    @else
    @include('layouts.other-sidebar')  
    @endif

    <div class="content-area">
        <div class="container-fluid mt30">
<div class="row">
        <div class="col-md-12">
                <div class="panel panel-default simple-panel">
                <div class="panel-heading">Add New Food</div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                @if(Auth::user()->role === 'admin')
                {!! Form::open(['url' => 'ad/create_food','class'=>'form-vertical','enctype'=>'multipart/form-data','files'=>true ]) !!}
                @elseif(Auth::user()->role === 'manager')                      
                {!! Form::open(['url' => 'pm/create_food','class'=>'form-vertical','enctype'=>'multipart/form-data','files'=>true ]) !!}
                        @elseif(Auth::user()->role === 'vendor')
                            {!! Form::open(['url' => 've/create_food','class'=>'form-vertical','enctype'=>'multipart/form-data','files'=>true ]) !!}

                        @elseif(Auth::user()->role === 'author')
                            {!! Form::open(['url' => 'au/create_food','class'=>'form-vertical','enctype'=>'multipart/form-data','files'=>true ]) !!}

                        @endif
                       
                        {{ csrf_field() }}
                       <div class="row">
                           <div class="col-md-6">
                               <div class="form-group">
                                   <label for="name" class="col-form-label">Food Name (eng) <b style="color: red">*</b></label>
                                   <input type="text" class="form-control" name="name"   required autofocus>
                               </div>
                           </div>
                           <div class="col-md-6">
                               <div class="form-group">
                                   <label for="name" class="col-form-label">Food Name (bn)<b style="color: red">*</b></label>
                                   <input type="text" class="form-control" name="name_bn"   required>
                               </div>
                           </div>
                             <div class="col-md-4">
                               <div class="form-group">
                                   <label for="name" class="col-form-label">Sell price <b style="color: red">*</b></label>
                                   <input type="text" class="form-control" name="price"   required />
                               </div>
                           </div>
                          
                           <div class="col-md-4">
                               <div class="form-group">
                                   <label for="name" class="col-form-label">Discount TK</label>
                                   <input type="text" class="form-control" name="discount"  value="0" />
                               </div>
                           </div>
                            <div class="col-md-4">
                               <div class="form-group">
                                   <label for="name" class="col-form-label">Buy price </label>
                                   <input type="text" class="form-control" name="buy_price"       />
                               </div>
                           </div>

                           <div class="col-md-4">
                               <div class="form-group">
                                   <label for="name" class="col-form-label">quantity per pack <b style="color: red">*</b></label>
                                   <input type="number" class="form-control" name="unit_quantity"   required>
                               </div>
                           </div>
                             <div class="col-md-4">
                               <div class="form-group relative-path">
                                   <label for="name" class="col-form-label">Unit <b style="color: red">*</b></label>

                                       <select class="form-control selectpicker" data-show-subtext="true"  name="unit"  data-live-search="true"  required>

                                       <option value="">Select Unit</option>
                                       @foreach ($units as $unit)
                                           <option value="{{ $unit->unit_name }}">{{$unit->unit_name}}</option>
                                       @endforeach
                                   </select>
                               </div>
                           </div>
                           <div class="col-md-4">
                               <div class="form-group ">
                                   <label for="name" class="col-form-label">Stock Amount <b style="color: red">*</b></label>
                                   <input type="number" class="form-control" name="stock_quantity"   required>
                               </div>
                           </div>
                           <div class="col-md-6">
                               <div class="form-group relative-path">
                                   <label for="name" class="col-form-label">Restaurant Name OR Shop Name <b style="color: red">*</b></label>

                                       <select class="form-control selectpicker" data-show-subtext="true"  name="restaurant_id"  data-live-search="true"  required>

                                       <option value="">Select Restaurant</option>
                                       @foreach ($restaurants as $restaurant)
                                           <option value="{{ $restaurant->id }}">{{$restaurant->restaurant_name_en}}</option>
                                       @endforeach
                                   </select>
                               </div>
                           </div>
                           

                           <div class="col-md-6">
                               <div class="form-group relative-path">
                                   <label for="name" class="col-form-label">Brand Name <b style="color: red">*</b></label>

                                       <select class="form-control selectpicker" data-show-subtext="true"  name="brand_id" required data-live-search="true" required>

                                       <option value="">Select Company</option>
                                       @foreach ($brands as $brand)
                                           <option value="{{ $brand->id }}">{{$brand->brand_name}}</option>
                                       @endforeach
                                   </select>
                               </div>
                           </div>


                           <!--default statts  value  is  1  so active-->
                           <input type="hidden" name="status" value="1">
                           <!--default statts  value  is  1  so active-->

                           <div class="col-md-5">
                               <div class="form-group">
                                   <label for="name" class="col-form-label">Featured Image <b style="color: red">*</b></label>
                                   <input type="file" name="featured_img">
                                   <small>width 400px height 400px</small>
                               </div>
                           </div>

                           <div class="col-md-7">
                               <div class="form-group">
                                   <label for="name" class="col-form-label">Gallery Image </label>
                                   <input type="file" name="gallery_img[]" multiple>
                                    <small>width 400px height 400px</small>
                           
                               </div>
                           </div>
                           <div class="col-md-12 mt10">
                               <div class="form-group">
                                   <label class="col-form-label">Tags</label>
                                   <textarea  name="tags" class="form-control" rows="1"></textarea>
                               </div>
                           </div>
                           <div class="col-md-12 mt10">
                               <div class="form-group">
                                   <label class="col-form-label">Description</label>
                                   <textarea  name="description" class="summernote" rows="4" ></textarea>
                               </div>
                           </div>
                           <div class="col-md-12">
                               <div class="form-group  mb-0">
                                   <button type="submit"  class="btn btn-success">
                                       Submit
                                   </button>
                               </div>
                           </div>
                       </div>

                        {!! Form::close() !!}

                </div>
            </div>
        </div>
        <div class="right-humberger-menu">

        </div>
        </div>
        </div>
        </div>
      
@endsection
