
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

                              {!! Form::open(['url' => 'pm/manager-save-expense','class'=>'form-horizontal','enctype'=>'multipart/form-data','files'=>true ]) !!}


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