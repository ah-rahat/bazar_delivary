
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
                    <div class="panel-heading">Add New Marketer  </div>
                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

              
                                       {!! Form::open(['url' => 'ad/add-marketer-coupon','class'=>'form-horizontal','enctype'=>'multipart/form-data','files'=>true ]) !!}
                                      
             
 
                         {{ csrf_field() }}
                           
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-right mt10">Coupon Code</label>
                            <div class="col-md-6">
                              <select class="form-control" name="coupon_code">
                                <option value="" selected="">Select Coupon</option>
                             	@foreach ($coupons as $index => $coupon)
							 
									  <option value="{{$coupon->coupon_code}}">  {{$coupon->coupon_code}}</option>
								 
								@endforeach
                                 
                                </select>
                            </div>
                        </div>
                           <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-right mt10">Assign Customer <span style="color: red;">*</span></label>
                            <div class="col-md-6">
                               <select class="form-control" name="user_id" required>
                                <option value="" selected="">Select user</option>
                             	@foreach ($users as $index => $user)
							 
									  <option value="{{$user->id}}">{{$user->name}} - {{$user->phone}}</option>
								 
								@endforeach
                                 
                                </select>  
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
                    <div class="panel-heading">Add New Marketer  </div>
                    <div class="panel-body">
                          
                           <table class="table table-striped table-bordered table-responsive inline-tbl" id="example">
							<thead>
								<tr>
									<th>
										SN
									</th>
									<th>
										Coupon Code
									</th>
									<th>
										Marketer Name
									</th>
								 
								</tr>
							</thead>
							<tbody>	@foreach ($marketers as $index => $marketer)
							 
								<tr>
									<td>
										{{$index+1}}
									</td>
									<td>
									  {{$marketer->coupon_code}}
									</td>
                                    	<td>
									 {{$marketer->name}}
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