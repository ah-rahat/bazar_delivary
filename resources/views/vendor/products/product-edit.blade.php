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
                        <div class="panel-heading">Update Product</div>
                        <div class="panel-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif


                            {!! Form::open(['url' => 've/vendor_product_update','class'=>'form-vertical','enctype'=>'multipart/form-data','files'=>true ]) !!}
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{$product->id}}"/>
                            <input type="hidden" name="old_featured_img" value="{{$product->featured_image}}"/>
                            <input type="hidden" name="old_gp_image_1" value="{{$product->gp_image_1}}"/>
                            <input type="hidden" name="old_gp_image_2" value="{{$product->gp_image_2}}"/>
                            <input type="hidden" name="old_gp_image_3" value="{{$product->gp_image_3}}"/>
                            <input type="hidden" name="old_gp_image_4" value="{{$product->gp_image_4}}"/>
                            {{--this  field for  update  image--}}

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">Product Title (ENG) <b
                                                    style="color: red">*</b></label>
                                        <input type="text" class="form-control" name="name" value="{{$product->name}}"
                                               required autofocus>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">Product Title (BN) <b
                                                    style="color: red">*</b></label>
                                        <input type="text" class="form-control" name="name_bn"
                                               value="{{$product->name_bn}}" required autofocus>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">price <b
                                                    style="color: red">*</b></label>
                                        <input type="number" class="form-control" name="price"
                                               value="{{$product->price}}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">discount TK</label>
                                        <input type="number" class="form-control" name="discount"
                                               value="{{$product->discount}}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">quantity per pack <b
                                                    style="color: red">*</b></label>
                                        <input type="text" class="form-control" name="unit_quantity"
                                               value="{{$product->unit_quantity}}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group relative-path">
                                        <label for="name" class="col-form-label">Unit <b
                                                    style="color: red">*</b></label>

                                        <select class="form-control selectpicker" data-show-subtext="true" name="unit"
                                                data-live-search="true" required>
                                            <option value="">Select Unit</option>
                                            @foreach ($units as $unit)
                                                <option value="{{ $unit->unit_name }}"
                                                        @if($product->unit == $unit->unit_name) selected @endif >{{$unit->unit_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="form-group "><label for="name" class="col-form-label">Stock Amount <b
                                                    style="color: red;">*</b></label> <input type="number"
                                                                                             value="{{$product->stock_quantity}}"
                                                                                             name="stock_quantity"
                                                                                             required="required"
                                                                                             class="form-control"></div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group relative-path">
                                        <label for="name" class="col-form-label">category Name <b
                                                    style="color: red">*</b></label>

                                        <select class="form-control selectpicker" data-show-subtext="true"
                                                name="category_id" data-live-search="true" required>

                                            <option value="">Select Category</option>
                                            @foreach ($category as $category)
                                                <option value="{{ $category->id }}"
                                                        @if($category->id ==$product->category_id) selected @endif >{{$category->cat_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                              <div class="col-md-6">
                                    <div class="form-group relative-path">
                                        <label for="name" class="col-form-label">Sub category Name  (*)<b
                                                    style="color: red">*</b></label>
 
                                        <select class="form-control selectpicker " data-show-subtext="true"
                                                name="sub_category_id[]"  data-live-search="true" multiple="" required>
                                                 
                                            <option value="">Select Sub Category</option>
                                            @foreach ($sub_category as $sub_category)
                                                <option value="{{ $sub_category->id }}"
                                                        @if(in_array($sub_category->id, explode(',', $product->sub_category_id))) selected @endif >{{$sub_category->sub_cat_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group relative-path">
                                        <label for="name" class="col-form-label">Child Sub category Name </label>
 
                                        <select class="form-control selectpicker"  data-show-subtext="true"
                                                data-live-search="true" name="child_sub_cats_id[]" multiple=""  >
                                              

                                            <option value="">Select Child Sub Category</option>
                                            @foreach ($child_sub_category as $child_sub_category)
                                                <option value="{{ $child_sub_category->id }}"
                                                        @if(in_array($child_sub_category->id, explode(',', $product->child_sub_cats_id))) selected @endif >{{$child_sub_category->child_cat_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">Brand Name <b style="color: red">*</b></label>

                                        <select class="form-control selectpicker" data-show-subtext="true"
                                                name="brand_id" required data-live-search="true" required>

                                            <option value="">Select Brand</option>
                                            @foreach ($brands as $brand)
                                                <option value="{{ $brand->id }}"
                                                        @if($product->brand_id == $brand->id) selected @endif >{{$brand->brand_name}}</option>
                                            @endforeach
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
                                        <small>Note: image size  is  400px width 400px height</small>
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
                                                  <small>Note: image size  is  400px width 400px height</small>
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
                                        <textarea name="description" rows="4"
                                                  class="summernote form-control">{{$product->description}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group  mb-0">
                                        <button type="submit" class="btn btn-success">
                                            Update Product
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
