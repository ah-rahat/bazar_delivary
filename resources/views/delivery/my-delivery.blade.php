@extends('layouts.app') @section('content') @if(Auth::user()->role === 'admin') @include('layouts.admin-sidebar') @else @include('layouts.other-sidebar') @endif
<div class="content-area">
    <div class="container-fluid mt30">
        <div class="row justify-content-center">
            <div class="col-md-6">

            </div>
        </div>
        <div class="container-fluid mt30">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="panel panel-default simple-panel">
                        <div class="panel-heading">Find Total Delivery  <span class="pull-right badge myDelivery" style="color: #f5f5f5;
background-color: #333;width: 48px;height: 30px;border-radius: 3px;line-height: 24px;">0</span></div>
                        <div class="panel-body">

                                <div class="form-group row">
                                    <div class="col-md-12">

                                            <select class="form-control"  required="" id="delivery_boy_id" name="delivery_boy_id"  >
                                                <option value="">Select Delivery Boy</option>
                                        @foreach ($boys  as $boy)

                                                <option value="{{$boy->id}}">{{$boy->name}}</option>
                                        @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="panel" style="margin-bottom:   15px;">
                                    <div class="panel-body" style="padding: 1px !important;">
                                        <div class="input-group input-daterange report_date_range">
                                            <input type="text" class="form-control start" placeholder="From  YY-MM-DD">
                                            <div class="input-group-addon">to</div>
                                            <input type="text" class="form-control end" placeholder="To  YY-MM-DD">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">

                                    <div class="col-md-12  text-center">
                                        <button type="submit" class="findelivery btn btn-primary btn-block">
                                            Submit
                                        </button>
                                    </div>
                                </div>

                        </div>
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


        jQuery(document).on('click', '.findelivery', function() {
            var startDate=jQuery("input.start").val();
            var delivery_boy_id=jQuery("#delivery_boy_id").val();

            var endDate=jQuery("input.end").val();
            if(startDate!='' && endDate!=''){
                jQuery.ajax({
                    type:'GET',
                    @if(Auth::user()->role=='admin')
                    url:'/web/ad/my-delivery/'+delivery_boy_id+'/'+startDate+'/'+endDate,
                    @else
                   url:'/web/pm/my-delivery/'+delivery_boy_id+'/'+startDate+'/'+endDate,
                   @endif

                    dataType: "json",
                    data:'_token = <?php echo csrf_token() ?>',
                    success:function(data) {
                        console.log();
                        jQuery(".myDelivery").text(data);
                        Command: toastr["info"]("Request Completed Successfully");
                    }
                });
            }
        });

    </script>
@endsection