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
                <div class="panel-heading">Edit Food</div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                @if(Auth::user()->role === 'admin')
                {!! Form::open(['url' => 'ad/update_food','class'=>'form-vertical','enctype'=>'multipart/form-data','files'=>true ]) !!}
                @elseif(Auth::user()->role === 'manager')                      
                {!! Form::open(['url' => 'pm/update_food','class'=>'form-vertical','enctype'=>'multipart/form-data','files'=>true ]) !!}
                        @elseif(Auth::user()->role === 'vendor')
                            {!! Form::open(['url' => 've/update_food','class'=>'form-vertical','enctype'=>'multipart/form-data','files'=>true ]) !!}

                        @elseif(Auth::user()->role === 'author')
                            {!! Form::open(['url' => 'au/update_food','class'=>'form-vertical','enctype'=>'multipart/form-data','files'=>true ]) !!}
                        @endif
                       
                        {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{$product->id}}"/>
                            
                               <input type="hidden" name="old_featured_img" value="{{$product->featured_image}}"/>
                            <input type="hidden" name="old_gp_image_1" value="{{$product->gp_image_1}}"/>
                            <input type="hidden" name="old_gp_image_2" value="{{$product->gp_image_2}}"/>
                            <input type="hidden" name="old_gp_image_3" value="{{$product->gp_image_3}}"/>
                            <input type="hidden" name="old_gp_image_4" value="{{$product->gp_image_4}}"/>
                       <div class="row">
                           <div class="col-md-6">
                               <div class="form-group">
                                   <label for="name" class="col-form-label">Food Name (eng) <b style="color: red">*</b></label>
                                   <input type="text" class="form-control" name="name" value="{{$product->name}}"  required autofocus>
                               </div>
                           </div>
                           <div class="col-md-6">
                               <div class="form-group">
                                   <label for="name" class="col-form-label">Food Name (bn)<b style="color: red">*</b></label>
                                   <input type="text" class="form-control" name="name_bn" value="{{$product->name_bn}}"   required>
                               </div>
                           </div>
                             <div class="col-md-4">
                               <div class="form-group">
                                   <label for="name" class="col-form-label">Sell price <b style="color: red">*</b></label>
                                   <input type="text" class="form-control" name="price" value="{{$product->price}}"   required />
                               </div>
                           </div>
                          
                           <div class="col-md-4">
                               <div class="form-group">
                                   <label for="name" class="col-form-label">Discount TK</label>
                                   <input type="text" class="form-control" name="discount"  value="{{$product->discount}}" value="0" />
                               </div>
                           </div>
                            <div class="col-md-4">
                               <div class="form-group">
                                   <label for="name" class="col-form-label">Buy price <b style="color: red">*</b></label>
                                   <input type="text" class="form-control" name="buy_price"  value="{{$product->buy_price}}"    />
                               </div>
                           </div>

                           <div class="col-md-4">
                               <div class="form-group">
                                   <label for="name" class="col-form-label">quantity per pack <b style="color: red">*</b></label>
                                   <input type="number" class="form-control" name="unit_quantity"  value="{{$product->unit_quantity}}"  required>
                               </div>
                           </div>
                             <div class="col-md-4">
                               <div class="form-group relative-path">
                                   <label for="name" class="col-form-label">Unit <b style="color: red">*</b></label>
 
                                       <select class="form-control selectpicker" data-show-subtext="true"  name="unit"  data-live-search="true"  required>

                                       <option value="">Select Unit</option>
                                           @foreach ($units as $unit)
                                                <option value="{{ $unit->unit_name }}"
                                                        @if($product->unit == $unit->unit_name) selected @endif >{{$unit->unit_name}}</option>
                                            @endforeach
                                   </select>
                               </div>
                           </div>
                           <div class="col-md-4">
                               <div class="form-group ">
                                   <label for="name" class="col-form-label">Stock Amount <b style="color: red">*</b></label>
                                   <input type="number" class="form-control" name="stock_quantity" value="{{$product->stock_quantity}}"   required>
                               </div>
                           </div>
                           <div class="col-md-6">
                               <div class="form-group relative-path">
                                   <label for="name" class="col-form-label">Restaurant Name <b style="color: red">*</b></label>

                                       <select class="form-control selectpicker" data-show-subtext="true"  name="restaurant_id"  data-live-search="true"  required>

                                       <option value="">Select Restaurant</option>
                                       @foreach ($restaurants as $restaurant)
                                           <option value="{{ $restaurant->id }}"  @if($product->restaurant_id == $restaurant->id) selected @endif >{{$restaurant->restaurant_name_en}}</option>
                                       @endforeach
                                   </select>
                               </div>
                           </div>
                           

                           <div class="col-md-4">
                               <div class="form-group relative-path">
                                   <label for="name" class="col-form-label">Brand Name <b style="color: red">*</b></label>

                                       <select class="form-control selectpicker" data-show-subtext="true"  name="brand_id" required data-live-search="true" required>

                                       <option value="">Select Company</option>
                                       @foreach ($brands as $brand)
                                                <option value="{{ $brand->id }}"
                                                        @if($product->brand_id == $brand->id) selected @endif >{{$brand->brand_name}}</option>
                                            @endforeach
                                   </select>
                               </div>
                           </div>
                  <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">Status</label> 
                                         <select class="form-control selectpicker" name="status"  >
                                              <option value="1" @if($product->status==1) selected @endif >Active</option>
                                            <option value="0" @if($product->status==0) selected @endif>Inactive</option>
                                    
                                        </select>
                                    </div>
                                </div>

                           <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">Featured Image <b
                                                    style="color: red">*</b></label><br>
                                        <img src="{{ url('/uploads/products') }}/{{$product->featured_image}}"
                                             height="100px" alt="">

                                        <input type="file" name="featured_img" value="{{$product->featured_image}}">
                                    </div>
                                </div>
                           <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="name" class="col-form-label">Gallery Image 1</label><br>
                                                <div style="height: 100px">
                                                @if($product->gp_image_1)
                                                    <img src="{{ url('/uploads/products') }}/{{$product->gp_image_1}}"
                                                         height="100px" alt="">
                                                @endif
                                                </div>
                                                <input type="file" name="gp_image_1">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="name" class="col-form-label">Gallery Image 2</label><br>
                                                <div style="height: 100px">
                                                @if($product->gp_image_2)
                                                    <img src="{{ url('/uploads/products') }}/{{$product->gp_image_2}}"
                                                         height="100px" alt="">
                                                @endif
                                                </div>
                                                <input type="file" name="gp_image_2">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="name" class="col-form-label">Gallery Image 3</label><br>
                                                <div style="height: 100px">
                                                    @if($product->gp_image_3)
                                                        <img src="{{ url('/uploads/products') }}/{{$product->gp_image_3}}"
                                                             height="100px" alt="">
                                                    @endif
                                                </div>
                                                <input type="file" name="gp_image_3">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="name" class="col-form-label">Gallery Image 4</label><br>
                                                <div style="height: 100px">
                                                    @if($product->gp_image_4)
                                                        <img src="{{ url('/uploads/products') }}/{{$product->gp_image_4}}"
                                                             height="100px" alt="">
                                                    @endif
                                                </div>
                                                <input type="file" name="gp_image_4">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                           <div class="col-md-12 mt10">
                               <div class="form-group">
                                   <label class="col-form-label">Tags</label>
                                   <textarea  name="tags" class="form-control" rows="1">{{$product->tags}}</textarea>
                               </div>
                           </div>
                           <div class="col-md-12 mt10">
                               <div class="form-group">
                                   <label class="col-form-label">Description</label>
                                   <textarea  name="description" class="summernote" rows="4" >{{$product->description}}</textarea>
                               </div>
                           </div>
                           <div class="col-md-12">
                               <div class="form-group  mb-0">
                                   <button type="submit"  class="btn btn-success">
                                       Update
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
