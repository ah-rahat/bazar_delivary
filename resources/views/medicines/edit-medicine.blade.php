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
                        <div class="panel-heading">Update Medicine</div>
                        <div class="panel-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

@if(Auth::user()->role === 'admin')
                          {!! Form::open(['url' => 'ad/update_medicine','class'=>'form-vertical','enctype'=>'multipart/form-data','files'=>true ]) !!}

                                @elseif(Auth::user()->role === 'manager')
                                    {!! Form::open(['url' => 'pm/update_medicine','class'=>'form-vertical','enctype'=>'multipart/form-data','files'=>true ]) !!}

                                @elseif(Auth::user()->role === 'author')
                            {!! Form::open(['url' => 'au/update_medicine','class'=>'form-vertical','enctype'=>'multipart/form-data','files'=>true ]) !!}
   @endif  
                             {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{$product->id}}"/>
                            <input type="hidden" name="old_featured_img" value="{{$product->featured_image}}"/>
                           

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">Medicine Title (ENG) <b
                                                    style="color: red">*</b></label>
                                        <input type="text" class="form-control" name="name" value="{{$product->name}}"
                                               required autofocus>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">Medicine Title (BN) <b
                                                    style="color: red">*</b></label>
                                        <input type="text" class="form-control" name="name_bn"
                                               value="{{$product->name_bn}}" required autofocus>
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
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">Sell price <b
                                                    style="color: red">*</b></label>
                                        <input type="text" class="form-control" name="price"
                                               value="{{$product->price}}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">discount TK</label>
                                        <input type="text" class="form-control" name="discount"
                                               value="{{$product->discount}}">
                                    </div>
                                </div>
                                  <div class="col-md-4">
                               <div class="form-group"> 
                                   <label for="name" class="col-form-label">Buy price <b style="color: red">*</b></label>
                                   <input type="text" class="form-control" name="buy_price" value="{{$product->buy_price}}"    />
                               </div>
                           </div>
                               
                              

                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">Company Name <b style="color: red">*</b></label>
 
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
                                  <div class="col-md-5">
                                    <div class="form-group relative-path">
                                        <label for="name" class="col-form-label">Sub category Name  <b
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
                       <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">Status</label> 
                                         <select class="form-control selectpicker" name="status"  > 
                                            <option value="1" @if($product->status==1) selected @endif >Active</option>
                                            <option value="0" @if($product->status==0) selected @endif>Inactive</option>
                                        </select>
                                    </div>
                                </div>
 

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">Featured Image <b
                                                    style="color: red">*</b></label><br>
                                        <img src="{{ url('/uploads/products') }}/{{$product->featured_image}}"
                                             height="100px" alt="">

                                        <input type="file" name="featured_img" value="{{$product->featured_image}}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">Strength<b
                                                    style="color: red">*</b></label><br>

                                        <input type="text" readonly class="form-control" value="{{$product->strength}}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">Featured<small>1=YES,0=NO</small></label>
                                        <input type="number" class="form-control" value="{{ $product->is_featured }}" name="is_featured" >

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
                                                  class="summernote">{{$product->description}}</textarea>
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
