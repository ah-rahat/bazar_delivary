
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
                    <div class="panel-heading">New Expense  </div>
                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                @if(Auth::user()->role === 'admin')
                     {!! Form::open(['url' => 'ad/save-income','class'=>'form-horizontal','enctype'=>'multipart/form-data','files'=>true ]) !!}
                                      
                 @elseif(Auth::user()->role === 'manager')                      
                      {!! Form::open(['url' => 'pm/save-income','class'=>'form-horizontal','enctype'=>'multipart/form-data','files'=>true ]) !!}
                                      
                 @endif 
 
                         {{ csrf_field() }}
                           
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-right mt10">Income Amount</label>
                            <div class="col-md-6">
                               <input type="number" class="form-control" name="amount" min="0" required="" />
                            </div>
                        </div>
                         
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right mt10">Income Date</label>
                                <div class="col-md-6">
                                      <div class="input-group date" data-provide="datepicker">
                  <input type="text" class="form-control" name="date"  required=""/>
                  <div class="input-group-addon">
                      <span class="glyphicon glyphicon-th"></span>
                  </div>
              </div>
                                </div>
                            </div>
                             
                              <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right mt10">Income Description</label>
                                <div class="col-md-6">
                                    <textarea class="form-control" name="purpose" required=""></textarea>
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
    @section('footerjs')
             
	<script>
   
   

 jQuery('.date').each(function() {
    jQuery(this).datepicker({
        clearDates:true,
         format: 'yyyy-mm-dd',
           todayHighlight: true,
          autoclose: true
    });
});

 	     
   
    </script>		

 
 @endsection
@endsection