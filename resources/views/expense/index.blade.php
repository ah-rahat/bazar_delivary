@extends('layouts.app') @section('content') @if(Auth::user()->role === 'admin') @include('layouts.admin-sidebar') @else @include('layouts.other-sidebar') @endif
<div class="content-area">
	<div class="container-fluid mt30">
		<div class="row justify-content-center">
        <div class="col-md-6">
         <div class="panel" style="margin-bottom:   15px;">
                    <div class="panel-body" style="padding: 1px !important;">
                        <div class="input-group input-daterange report_date_range">
                        <input type="text" class="form-control start" placeholder="From  YY-MM-DD">
                        <div class="input-group-addon">to</div>
                        <input type="text" class="form-control end" placeholder="To  YY-MM-DD">
                        </div>
                    </div>
         </div>
         
        </div>
             <div class="col-md-6">
         <div class="panel" style="margin-bottom:   15px;">
                    <div class="panel-body" style="padding: 16px !important;height: 36px;">
                        <div class="input-group  ">
                         <div class="date-show">
                        <div class="pull-left">
                         Expense From <span></span></div> &nbsp;&nbsp;
                         <div class="total_expense pull-right" style="color: #ff8f00;font-size: 15px;"></div>
                         </div>
                        </div>
                    </div>
         </div>

        </div>
			<div class="col-md-12">

				<div class="panel panel-default simple-panel">
					<div class="panel-heading">
						Office Expense List
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
                                    <th>
                                        Expense Date
                                    </th>
									<th>
										Entry Date
									</th>
									<th>
										Category
									</th>
									<th>
										Purpose
									</th>
									@if(Auth::user()->role=='admin')
									<th>
										Added By
									</th>
									@endif
									<th class="text-center" width="35px">
									</th>
									@if(Auth::user()->role=='admin')
									<th width="45px">
									</th>
									@endif
								</tr>
							</thead>
							<tbody>
								@foreach ($expenses as $index => $expense)
								<tr>
									<td>
										{{$index+1}}
									</td>
									<td>&#2547; {{$expense->amount}}
									</td>
									<td>
										{{date('d M y', strtotime($expense->date))}}
									</td>
                                    <td>
                                        {{date('d M y', strtotime($expense->created_at))}}
                                    </td>
									<td>
										<small>
											@if($expense->type == 'Salary')

												{{ date('F', mktime(0, 0, 0, $expense->salary_month, 10))}}
											@endif {{$expense->type}}

											@foreach($employees as $employee)
												@if($employee->id == $expense->employee_id)
												 {{$employee->name}}
												@endif
											@endforeach


										</small>
									</td>
									<td>
										<small>
											{{$expense->purpose}}
										</small>
									</td>
									@if(Auth::user()->role=='admin')
									<td>
										<small>
											<i class="fa fa-info-circle">
											</i>
											{{$expense->name}}
										</small>
									</td>
									@endif
									<td class="text-center">
										@if($expense->status==1)
										<img title="Approved Bill" src="https://gopalganjbazar.com/web/public/images/success.png" width="21px" />
										@else
										<img title="Pending Bill" src="https://gopalganjbazar.com/web/public/images/info.png" width="21px" />
										@endif
									</td>
									@if(Auth::user()->role=='admin')
									<td class="text-center">
										<div id="cancel_order_modal_{{$expense->id}}" role="dialog" class="modal cancel-modal fade">
											<div class="modal-dialog">
												<div class="modal-content text-center">
													<div class="modal-body">
														<img src="https://gopalganjbazar.com/web/public/images/info.png" alt="" class="status-icon mt15">
														<h2>
															Are you sure you want to Approve this Expense ?
														</h2>
													</div>
												 {!! Form::open(['url' => 'ad/approve-expense','class'=>'form-horizontal','enctype'=>'multipart/form-data','files'=>true ]) !!}
                                                	<div class="modal-footer">
                                                   {{ csrf_field() }}
														<button type="button" data-dismiss="modal" class="btn btn-default mt5">
															CANCEL
														</button>

														<input type="hidden" name="id" value="{{$expense->id}}"/>
														<button type="submit" class="btn btn-success">
															Yes
														</button>

													</div>
                                                    	{!! Form::close() !!}
												</div>
											</div>
										</div>
										@if($expense->status==0)
										<a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#cancel_order_modal_{{$expense->id}}" href="#"><i class="fa  fa-check-circle"></i> Approve</a>
										@endif
									</td>
									@endif
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
 @section('footerjs')
<script>
    jQuery(".report_date_range input").val('');

      jQuery('.input-daterange input').each(function() {
    jQuery(this).datepicker({
        clearDates:true,
         format: 'yyyy-mm-dd',
           todayHighlight: true,
          autoclose: true
    });
});


 jQuery(document).on('change', '.report_date_range input', function() {
  var startDate=jQuery("input.start").val();
    var endDate=jQuery("input.end").val();
    if(startDate!='' && endDate!=''){
         jQuery.ajax({
               type:'GET',
                url:'/web/ad/expense-calculate/'+startDate+'/'+endDate,
                dataType: "json",
               data:'_token = <?php echo csrf_token() ?>',
               success:function(data) {
                     console.log();

                    var finalStartDate = moment(startDate).format('MMM Do ');
                      var finalEndDate = moment(endDate).format('MMM Do ');
                    jQuery(".date-show span").text(finalStartDate + " - "+ finalEndDate );
                   console.log(data);

                    jQuery(".total_expense").text(  data.total_expense_amount.total_expense.toLocaleString());

                  Command: toastr["info"]("Request Completed Successfully");
               }
            });
    }
});

</script>
 @endsection