
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
                    <div class="panel-heading">Add New Expense  Type</div>
                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

               
                                       {!! Form::open(['url' => 'ad/save-expense-category','class'=>'form-horizontal','enctype'=>'multipart/form-data','files'=>true ]) !!}
                                      
                
 
                         {{ csrf_field() }}
                           
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-right mt10">Expense Category name</label>
                            <div class="col-md-6">
                               <input type="text" class="form-control" name="type"   required="" />
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
                <div class="panel panel-default simple-panel">
					<div class="panel-heading">
						  Expense Category List
					</div>
					<div class="panel-body">
                      @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
						<table class="table table-striped table-bordered table-responsive inline-tbl" id="example">
							<thead>
								<tr>
									<th>
										SN
									</th>
									<th>
										Amount
									</th>
									 
								</tr>
							</thead>
							<tbody>
								@foreach ($expense_categories as $index => $expense_category)
								<tr>
									<td>
										{{$index+1}}
									</td>
									<td>
									  {{$expense_category->type}}
									</td> 
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
            </div>
        </div>
    </div>
    </div>
@endsection