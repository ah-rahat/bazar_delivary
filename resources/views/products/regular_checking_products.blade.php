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
                        <div class="panel-heading">Regular Checking Products List</div>
                        <div class="panel-body">
                            <div>
                                <table id="example" class="table table-striped regulatList">
                                    <thead>
                                    <tr>
                                         <td>P.Image</td>
                                        <td>name</td> 
                                        <td>Sale price</td>
                                        <td>price</td>
                                         <td>discount</td>
                                        <td>quantity</td>
                                          
                                        <td width="99px"> </td>
                                        {{--<td>gp_image_2</td>--}}
                                        {{--<td>gp_image_3</td>--}}
                                        {{--<td>gp_image_4</td>--}}
                                        {{--<td>user_id</td>--}}
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($products as $product)

                                        <tr id="{{$product->id}}">
                                        <td><img src="{{ url('/uploads/products') }}/{{$product->featured_image}}" width="55px"></td>
                                          
                                           
                                              <td>{{$product->name_bn }}</td>
                                               <td class="main_price"> &#2547; <span>{{$product->price - $product->discount }}</span>  </td>
                                            <td><input type="text" class="form-control price"  style="width: 75px !important;"   value="{{$product->price}}" /></td>
                                            <td><input type="text" class="form-control discount"  style="width: 75px !important;"  value="{{$product->discount}}" /></td>
                                            <td>{{$product->unit_quantity}} {{$product->unit}}</td>  
                                             
                                               
                                            <td>
                                                @if(Auth::user()->role != 'author')
                                                    <a class="btn-sm btn-warning pull-right" href="products/{{$product->id}}"><i class="fa fa-edit"></i></a>
                                                @endif
                                              <button type="button" class="btn-xs btn-success pull-right update_price" data-id="{{$product->id}}"    style="margin-right: 5px;">  SAVE</button>
                                       
                                               
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
 
  
      jQuery('.regulatList .update_price').click(function () {
             var  product_id=jQuery(this).data('id');
             var price=jQuery("#"+product_id + " .price").val();
             var discount=jQuery("#"+product_id + " .discount").val();
         
          jQuery.ajax({
               type:'GET',
                url:'regular_product_price_update/'+product_id+'/'+price+'/'+discount,
               dataType: "json",
               data:'_token = <?php echo csrf_token() ?>',
               success:function(res) { 
                console.log(res);
                 Command: toastr["info"]("Product Price Updated");
                   
                jQuery("#"+product_id + " .price").val(res.product.price);
                jQuery("#"+product_id + " .main_price span").text(res.product.price - res.product.discount);
                jQuery("#"+product_id + " .discount").val(res.product.discount);
                jQuery("#"+product_id ).addClass("checked");  
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
