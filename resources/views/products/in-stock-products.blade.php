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
{{--                                         <td>P.Image</td>--}}
                                        <td>name</td> 
                                         <td>Weight</td> 
                                         <td>Stock</td> 
                                        <td>Sale&nbsp;price</td>
                                        
                                        <td>Buy price</td>
                                        <td>L.STOCK</td>
                                    @if(Auth::user()->role === 'admin')
                                         <td width="31px"> </td> 
                                        <td width="73px"> </td> 
                                        @endif
                                        
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($products as $product)
                                    @if ($product->stock_quantity > 0)


                                        <tr id="{{$product->id}}">
{{--                                        <td><img src="{{ url('/uploads/products') }}/{{$product->featured_image}}" width="55px"></td>--}}
                                          
                                           
                                              <td>{{$product->name }}</td>
                                                <td>{{$product->unit_quantity }}{{$product->unit }}</td>
                                               <td>{{$product->stock_quantity }}</td>
                                               <td class="main_price"> &#2547; <span>{{$product->price - $product->discount }}</span>  </td>
                                           
                                           
                                            <td  @if($product->price - $product->discount < $product->buy_price) style="background: red;" @endif>
                                              @if(Auth::user()->role === 'admin')


                                            <input type="text" readonly class="form-control price"  style="width: 75px !important;"
                                                   value="{{$product->buy_price}}" />
                                              @else
                                              {{$product->buy_price}}
                                              @endif
                                            </td>
                                            <td>
                                                @if(Auth::user()->role === 'admin')
                                                    @foreach ($lowstocks as $low)
                                                    @if($product->id == $low->product_id)
                                                        <div class="text-center">{{$low->quantity}} </div>
                                                        @endif
                                                    @endforeach

                                                    <input type="text" class="form-control lowStockQuantity" title="LOW Stock Quantity" placeholder="LOW Stock"  style="width: 45px !important;"   />

                                                @endif
                                            </td>
                                             @if(Auth::user()->role === 'admin')
                                            <td>
                                                @if(Auth::user()->role === 'admin')
                                             <a class="btn btn-sm btn-info pull-right" href="products/{{$product->id}}"><i class="fa fa-rocket"></i></a>
                                                @endif
                                            </td>
                                            <td>
                                                @if(Auth::user()->role === 'admin')
                                             <button type="button" class="btn-sm btn-warning pull-right update_price" data-id="{{$product->id}}"    style="margin-right: 5px;">  UPDATE</button>
                                                @endif
                                            </td>
                                            @endif
                                            
                                        </tr>
                                    @endif
                                    @endforeach
                                    </tbody>
                                </table>

                                {{ $products->links() }}
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
             var lowStockQuantity=jQuery("#"+product_id + " .lowStockQuantity").val();

         
          jQuery.ajax({
               type:'GET',
                url:'stock-product-buy-price/'+product_id+'/'+price+'/'+lowStockQuantity,
               dataType: "json",
               data:'_token = <?php echo csrf_token() ?>',
               success:function(res) { 
                console.log(res);
                 Command: toastr["info"]("Product Buy Price Updated");
                   
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
