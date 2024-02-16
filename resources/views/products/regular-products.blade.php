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
                        <div class="panel-heading">Assign Regular Products List</div>
                        <div class="panel-body">
                       <div class="row p_lists">
               
                      @foreach ($products as $product)
                        <div class="col-md-6">
                            <div class="panel panel-default regular">
                                <div class="panel-body">
                                    <div class="checkbox checkbox-success checkbox-inline">
                                      
                                        <input type="checkbox" id="{{$product->id}}" 
                                        value="{{$product->id}}"
                                         @foreach ($lists as $list)
                                         @if($list->id === $product->id)
                                         checked=""
                                         @endif
                                         @endforeach  
                                         />
                                         
                                       
                                         <label for="{{$product->id}}"><img class="img-thumbnail pull-left" style="margin-right: 10px;" src="{{ url('/uploads/products') }}/{{$product->featured_image}}" height="45px" width="45px">
                                         <span>{{$product->name_bn}}</span><br />
                                          <small class="quantity-show"> {{$product->unit_quantity}} {{$product->unit}} </small>
                                          </label>
                                    </div>
                                </div>
                            </div>
                        </div><!--end-->
                        @endforeach  
                       
                       
                       
                       </div>

                            <div>
                                 
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
 		    

                
                      
          jQuery.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                  }
              });
      
      jQuery('.checkbox  input').click(function () {
    if (!jQuery(this).is(':checked')) {
          jQuery.ajax({
               type:'GET',
               url:'regular_products/'+this.id,
               dataType: "json",
               data:'_token = <?php echo csrf_token() ?>',
               success:function(res) { 
                console.log(res);
               Command: toastr["error"]("Product Removed From Daily List");  
                  
                   
               }
            });
    }else{ 
         jQuery.ajax({
               type:'GET',
               url:'regular_products/'+this.id,
               dataType: "json",
               data:'_token = <?php echo csrf_token() ?>',
               success:function(res) {
                 console.log(res);
                  Command: toastr["info"]("Product Added From Daily List");
                    
               }
            });
    }
});
       
   
       
       
		</script>
@endsection
