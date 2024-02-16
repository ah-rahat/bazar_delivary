
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
                        {!! Form::open(['url' => 'ad/save-expense','class'=>'form-horizontal','enctype'=>'multipart/form-data','files'=>true ]) !!}
                 @elseif(Auth::user()->role === 'manager')                      
                         {!! Form::open(['url' => 'pm/save-expense','class'=>'form-horizontal','enctype'=>'multipart/form-data','files'=>true ]) !!}
                 @endif 
 
                         {{ csrf_field() }}
                           
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-right mt10">Expense Amount</label>
                            <div class="col-md-6">
                               <input type="number" class="form-control" name="amount" min="0" required="" />
                            </div>
                        </div>
                         
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right mt10">Expense Date</label>
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
                                <label for="name" class="col-md-4 col-form-label text-right mt10">Expense Category</label>
                                <div class="col-md-6">
                                <select class="form-control" id="category" required="" name="type"  >
                                     <option value="">Select Expense Category</option>
                                     	@foreach ($expense_categories as $index => $expense_category)
                                    <option value="{{$expense_category->id}}">{{$expense_category->type}}</option>
                                    	@endforeach
                                    </select>
                                </div>
                            </div>
                            <div id="salary">
                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-right mt10">Select Employee</label>
                                    <div class="col-md-6">
                                        <select class="form-control" name="employee_id"  >
                                            <option value="">Select  Employee</option>
                                            @foreach ($employees as $index => $employee)
                                                <option value="{{$employee->id}}">{{$employee->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-right mt10">Select Month</label>
                                    <div class="col-md-6">
                                        <select class="form-control"  name="month" >
                                                <option value="">Select Month</option>
                                                <option value="1">January</option>
                                                <option value="2">February</option>
                                                <option value="3">March</option>
                                                <option value="4">April</option>
                                                <option value="5">May</option>
                                                <option value="6">June</option>
                                                <option value="7">July</option>
                                                <option value="8">August</option>
                                                <option value="9">September</option>
                                                <option value="10">October</option>
                                                <option value="11">November</option>
                                                <option value="12">December</option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right mt10">Money Source</label>
                                <div class="col-md-6">
                                    <select class="form-control"  name="source" >
                                        <option value="">Select Source</option>
                                        <option value="1">Minus From Stock Money</option>
                                        <option value="0">Others</option>

                                    </select>
                                </div>
                            </div>
                              <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right mt10">Expense Purpose</label>
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
@endsection
@section('footerjs')
    <script>
        jQuery("#salary").hide();
        jQuery(document).on('click', '.btn-primary', function() {
          jQuery('.btn-primary').hide();
        });
        jQuery(document).on('change', '#category', function() {
            var cat_id=jQuery("#category").val();
           if(cat_id == 14){
               jQuery("#salary").show();
           }else{
               jQuery("#salary").hide();
           }
        });

    </script>
@endsection