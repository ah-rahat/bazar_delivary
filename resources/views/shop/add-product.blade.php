@extends('layouts.app')

@section('content')
    @if(Auth::user()->role === 'admin')
        @include('layouts.admin-sidebar')
    @else
        @include('layouts.shop-sidebar')
    @endif

    <div class="content-area">
        <div class="container-fluid mt30">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default simple-panel">
                        <div class="panel-heading">Create Product</div>
                        <div class="panel-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif


                                {!! Form::open(['url' => 'shop/create_product','class'=>'form-vertical','enctype'=>'multipart/form-data','files'=>true ]) !!}



                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">Product Title (eng) <b
                                                    style="color: red">*</b></label>
                                        <input type="text" class="form-control" name="name" required autofocus>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">Product Title (bn)<b
                                                    style="color: red">*</b></label>
                                        <input type="text" class="form-control" name="name_bn" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">Sell price <b style="color: red">*</b></label>
                                        <input type="text" class="form-control" name="price" required/>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">Discount TK</label>
                                        <input type="text" class="form-control" name="discount" value="0"/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">Buy price <b
                                                    style="color: red">*</b></label>
                                        <input type="text" class="form-control" name="buy_price"/>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">quantity per pack <b
                                                    style="color: red">*</b></label>
                                        <input type="number" class="form-control" name="unit_quantity" required>
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
                                                <option value="{{ $unit->unit_name }}">{{$unit->unit_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="form-group ">
                                        <label for="name" class="col-form-label">Stock Amount <b
                                                    style="color: red">*</b></label>
                                        <input type="number" class="form-control" name="stock_quantity" step=any
                                               required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group relative-path">
                                        <label for="name" class="col-form-label">category Name <b
                                                    style="color: red">*</b></label>

                                        <select class="form-control selectpicker" data-show-subtext="true"
                                                name="category_id" data-live-search="true" required>

                                            <option value="">Select Category</option>
                                            @foreach ($category as $category)
                                                <option value="{{ $category->id }}">{{$category->cat_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group relative-path">
                                        <label for="name" class="col-form-label">Sub category Name <b
                                                    style="color: red">*</b></label>

                                        <select class="form-control selectpicker" data-show-subtext="true"
                                                name="sub_category_id[]" data-live-search="true" multiple>

                                            <option value="">Select Sub Category</option>
                                            @foreach ($sub_category as $sub_category)
                                                <option value="{{ $sub_category->id }}">{{$sub_category->sub_cat_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group relative-path">
                                        <label for="name" class="col-form-label">Child Sub category Name </label>

                                        <select class="form-control selectpicker" data-live-search="true"
                                                name="child_sub_category_id[]" multiple>

                                            <option value="">Select Child Sub Category</option>
                                            @foreach ($child_sub_category as $child_sub_category)
                                                <option value="{{ $child_sub_category->id }}">{{$child_sub_category->child_cat_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group relative-path">
                                        <label for="name" class="col-form-label">company Name <b
                                                    style="color: red">*</b></label>

                                        <select class="form-control selectpicker" data-show-subtext="true"
                                                name="brand_id" required data-live-search="true" required>

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
                                        <label for="name" class="col-form-label">Featured Image <b
                                                    style="color: red">*</b></label>
                                        <input type="file" name="featured_img">
                                    </div>
                                </div>


                                <div class="col-md-12 mt10">
                                    <div class="form-group">
                                        <label class="col-form-label">Tags</label>
                                        <textarea name="tags" class="form-control" rows="1"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mt10">
                                    <div class="form-group">
                                        <label class="col-form-label">Description</label>
                                        <textarea name="description" class="summernote" rows="4"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group  mb-0">
                                        <button type="submit" class="btn btn-success">
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
