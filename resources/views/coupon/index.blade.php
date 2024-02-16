@extends('layouts.app') @section('content') @if(Auth::user()->role === 'admin') @include('layouts.admin-sidebar') @else @include('layouts.other-sidebar') @endif
<div class="content-area">
	<div class="container-fluid mt30">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="panel panel-default simple-panel">
					<div class="panel-heading">
						Coupon Discount List
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
										Coupon Code
									</th>
									<th>
										Discount Amount
									</th>
									<th>
										Active From
									</th>
                                    	<th>
										Active End
									</th>
                                    	<th>
										Coupon Used
									</th>
								  	<th>
										Status
									</th> 
                                    	 	<th>
										 
									</th> 
								</tr>
							</thead>
							<tbody>
								@foreach ($coupons as $index => $coupon)
								<tr>
									<td>
										{{$index+1}}
									</td>
									<td>
									  {{$coupon->coupon_code}}
									</td>
                                    	<td>
										&#2547; {{$coupon->coupon_discount}}
									</td>
                                    	<td>
									 	{{date('d M y', strtotime($coupon->active_from))}}
									</td>
									<td>
										{{date('d M y', strtotime($coupon->active_until))}}
									</td>
									<td> 
									 	{{$coupon->coupon_used}} 
									</td>
								  	<td> 
                                    @if($coupon->status==0)
                                    <small class="badge">Active</small>
                                    @else
                                     <small class="badge">InActive</small>
                                    @endif
									  
									</td>
                                    <td>
                                    <a class="btn btn-sm btn-warning" href="edit-coupon/{{$coupon->id}}"><i class="fa fa-pencil"></i></a>
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