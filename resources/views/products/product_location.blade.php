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
                <div class="col-md-12 mt30">
                    <div class="panel panel-success">
                        <div class="panel-heading">Products Location in Rake</div>
                        <div class="panel-body">
                            <div>
                                <table id="example" class="table table-striped regulatList">
                                    <thead>
                                    <tr>
                                        <td>P.Image</td>
                                        <td>name</td>
                                        <td>Weight</td>
                                        <td>RAK NO-TAK NO</td>
                                        <td>RAK NO-TAK NO</td>
                                        <td></td>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach ($products as $product)

                                        <tr id="{{$product->id}}">
                                            <td><img src="{{ url('/uploads/products') }}/{{$product->featured_image}}" width="55px"></td>


                                            <td>{{$product->name }}</td>
                                            <td>{{$product->unit_quantity }}{{$product->unit }}</td>
                                            <td>
                                                @foreach ($product_stock_locations as $product_stock_location)
                                                    @if($product->id == $product_stock_location->product_id)
                                                        <div class="text-center">{{$product_stock_location->rak_no}} </div>
                                                    @endif
                                                @endforeach

                                            </td>
                                            <td><input type="text" placeholder="RAK NO-TAK NO" class="form-control" id="rak_no_{{$product->id}}" required> </td>
                                                <td>
                                                        <a class="btn btn-sm btn-success pull-right  savebtn" data-id="{{$product->id}}" href="#"><i class="fa fa-save"></i></a>
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
    </div>

@section('footerjs')
    <script>




      jQuery.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });


      jQuery('.savebtn').click(function () {
        var  product_id=jQuery(this).data('id');
        var  rak_no=jQuery('#rak_no_'+product_id).val();

        jQuery.ajax({
          type:'GET',
          url:'product-location/'+product_id+'/'+rak_no,
          dataType: "json",
          data:'_token = <?php echo csrf_token() ?>',
          success:function(res) {
            console.log(res);
            Command: toastr["info"]("Product RAK INFO Updated");

            //jQuery("#"+product_id + " .price").val(res.product.price);
            // jQuery("#"+product_id + " .main_price span").text(res.product.price - res.product.discount);
            //jQuery("#"+product_id + " .discount").val(res.product.discount);
            //jQuery("#"+product_id ).addClass("checked");
          }
        });

      });


      toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
      }


    </script>

@endsection
