@extends('layouts.app') @section('content') @if(Auth::user()->role === 'admin') @include('layouts.admin-sidebar') @else @include('layouts.other-sidebar') @endif
<div class="content-area">
	<div class="container-fluid mt30">
		<div class="row justify-content-center">  
        <div class="col-md-6">
        <div class="panel" style="margin-bottom:   5px;">
					<div class="panel-body" style="padding:  7px 15px !important;"> 
                       <div style="color: #7cb342;
text-transform: uppercase;font-weight: 600;font-size: 13px; ">
  Other Income: 
  <small class="date" style="color: #ff8f00;"></small>
   <b class="pull-right amount_tk" style="color: #ff8f00;font-size: 15px;">{{$income_amount->amount}}</b>
   <span class="pull-right" style="margin-top: 2px;">&#2547;</span>
   </div> 
					</div>
				</div>
        </div>   
        
         <div class="col-md-6">
          <div class="panel" style="margin-bottom:   5px;">
					<div class="panel-body" style="padding: 1px !important;">
					  <div class="input-group input-daterange report_date_range">
    <input type="text" class="form-control start" placeholder="From  YY-MM-DD">
    <div class="input-group-addon">to</div>
    <input type="text" class="form-control end" placeholder="To  YY-MM-DD">
</div>


					</div>
				</div>
        </div>   
			<div class="col-md-12">
                
				<div class="panel panel-default simple-panel">
					<div class="panel-heading">
						Other Income List
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
										Date
									</th>
									<th>
										Purpose
									</th> 
								</tr>
							</thead>
							<tbody>
								@foreach ($incomes as $index => $income)
								<tr>
									<td>
										{{$index+1}}
									</td>
									<td>
										&#2547; {{$income->amount}}
									</td>
									<td>
										{{date('d M y', strtotime($income->date))}}
									</td>
									<td>
										<small>
											{{$income->purpose}}
										</small>
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
                url:'/ad/other-income/'+startDate+'/'+endDate, 
                dataType: "json",
               data:'_token = <?php echo csrf_token() ?>', 
               success:function(data) {
                     console.log(data.income_amount);
                    jQuery(".amount_tk").text('0');
                    jQuery(".date").text(startDate +' TO ' + endDate);
                    jQuery(".amount_tk").text(data.income_amount.amount.toLocaleString());
                    
                  Command: toastr["info"]("Request Completed Successfully");
               }
            });
    }
});


 </script>
 @endsection