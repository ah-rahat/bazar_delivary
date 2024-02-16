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
                <div class="panel-heading">Create Medicine</div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                @if(Auth::user()->role === 'admin')
                                        {!! Form::open(['url' => 'ad/save-medicine','class'=>'form-vertical','enctype'=>'multipart/form-data','files'=>true ]) !!}
                 @elseif(Auth::user()->role === 'manager')                      
                                         {!! Form::open(['url' => 'pm/save-medicine','class'=>'form-vertical','enctype'=>'multipart/form-data','files'=>true ]) !!}
                        @elseif(Auth::user()->role === 'author')
                            {!! Form::open(['url' => 'au/save-medicine','class'=>'form-vertical','enctype'=>'multipart/form-data','files'=>true ]) !!}

                        @endif
                       
                        {{ csrf_field() }}
                       <div class="row">
                           <div class="col-md-4">
                               <div class="form-group">
                                   <label for="name" class="col-form-label">Medicine Name (eng) <b style="color: red">*</b></label>
                                   <input type="text" class="form-control" name="name"   required autofocus>
                               </div>
                           </div>
                           <div class="col-md-4">
                               <div class="form-group">
                                   <label for="name" class="col-form-label">Medicine Name (bn)<b style="color: red">*</b></label>
                                  
                                     <input type="text" class="form-control" name="name_bn"   required>
                               </div>
                           </div>
                              <div class="col-md-4">
                               <div class="form-group">
                                   <label for="name" class="col-form-label">Medicine Type <b style="color: red">*</b></label>
                                 
                                   
                                    <select class="form-control selectpicker" name="dosages_description" data-show-subtext="true"   data-live-search="true" required>
                                     <option value=" ">Select</option>
                                    <option value="Injection">Injection</option>
                                    
                                       <option value="Tablet">Tablet</option>
                                        <option value="Chewable tablets">Chewable tablets</option>
                                          <option value="capsule">capsule</option>
                                     <option value="Bolus">Bolus</option>
                                      <option value="Powder">Powder</option>
                                       <option value="Solution">Solution</option>
                                        <option value="Suspension">Suspension</option>
                                      
                                          <option value="IV Infusion">IV Infusion</option>
                                            <option value="Oral Solution">Oral Solution</option>
                                              <option value="Emulsion">Emulsion</option>
                                                <option value="Oral Powder">Oral Powder</option>
                                                  <option value="Xr Tablet">Xr Tablet</option>
                                                    <option value="Water Soluble Powder">Water Soluble Powder</option>
                                                     <option value="Vaginal Tablet">Vaginal Tablet</option>
                                                      <option value="Vaginal Suppository">Vaginal Suppository</option>
                                                       <option value="Vaginal Gel">Vaginal Gel</option>
                                                        <option value="Vaginal Cream">Vaginal Cream</option>
                                                         <option value="Topical Suspension">Topical Suspension</option>
                                                          <option value="Topical Solution">Topical Solution</option>
                                                           <option value="Tincture">Tincture</option>
                                                            <option value="Syrup">Syrup</option>
                                                               <option value="Pediatric Drops">Pediatric Drops</option>
                                                                <option value="Cream">Cream</option>
                                                     
                                                    
                                    
                                    </select>
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

                                   <select class="form-control selectpicker" data-show-subtext="true"  name="unit" data-live-search="true" required>
                                       <option value="">Select Unit</option>
                                       @foreach ($units as $unit)
                                           <option   value="{{ $unit->unit_name }}">{{$unit->unit_name}}</option>
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
                                   <label for="name" class="col-form-label">Buy price <b style="color: red">*</b></label>
                                   <input type="text" class="form-control" name="buy_price"     />
                               </div>
                           </div>
                            <div class="col-md-4">
                               <div class="form-group">
                                   <label for="name" class="col-form-label">Generic  Name  </label>
                                   <input type="text" class="form-control" name="generic_name"    >
                               </div>
                           </div>
                            <div class="col-md-2">
                               <div class="form-group">
                                   <label for="name" class="col-form-label">Strength<b style="color: red">*</b></label>
                                   <input type="text" class="form-control" name="strength"   required>
                               </div>
                           </div>
                           <div class="col-md-3">
                               <div class="form-group">
                                   <label for="name" class="col-form-label">use_for<b style="color: red">*</b></label>
                                    <select class="form-control" name="use_for">
                                     <option value=" ">Select</option>
                                    <option value="Veterinary">Veterinary</option>
                                     <option value="Veterinary">Veterinary</option>
                                     <option value="Human">Human</option>
                                    
                                    </select>
                               </div>
                           </div>
                           <div class="col-md-3">
                               <div class="form-group">
                                   <label for="name" class="col-form-label">DAR </label>
                                   <input type="text" class="form-control" name="DAR"    />
                               </div>
                           </div>
                            
                           <div class="col-md-4">
                               <div class="form-group relative-path">
                                   <label for="name" class="col-form-label">category Name <b style="color: red">*</b></label>

                                       <select class="form-control selectpicker" data-show-subtext="true"  name="category_id"  data-live-search="true"  required>

                                       <option value="">Select Category</option>
                                       @foreach ($category as $category)
                                           <option value="{{ $category->id }}">{{$category->cat_name}}</option>
                                       @endforeach
                                   </select>
                               </div>
                           </div>
                            <div class="col-md-4">
                               <div class="form-group relative-path">
                                   <label for="name" class="col-form-label">Sub category Name  <b
                                                    style="color: red">*</b></label>

                                       <select class="form-control selectpicker" data-show-subtext="true"  name="sub_category_id[]"  data-live-search="true" multiple>

                                       <option value="">Select Sub Category</option>
                                       @foreach ($sub_category as $sub_category)
                                           <option   value="{{ $sub_category->id }}">{{$sub_category->sub_cat_name}}</option>
                                       @endforeach
                                   </select>
                               </div>
                           </div>
                           <div class="col-md-4">
                               <div class="form-group relative-path">
                                   <label for="name" class="col-form-label">company Name <b style="color: red">*</b></label>

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
