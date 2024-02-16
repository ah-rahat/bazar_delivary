@extends('layouts.app')
@section('content')
      @if(Auth::user()->role === 'admin')
    @include('layouts.admin-sidebar')
    @else
    @include('layouts.shop-sidebar')
    @endif
    <div class="content-area">
        <div class="container-fluid mt30">
            <div class="row justify-content-center">
                <div class="col-md-12 mt30">
                    <div class="panel panel-success">
                        <div class="panel-heading">Need To  Stock Products List</div>
                        <div class="panel-body">
                            <div>
                                <table id="example" class="table table-striped regulatList">
                                    <thead>
                                    <tr>
                                         <td>P.Image</td>
                                        <td>name</td> 
                                         <td>Weight</td> 
                                         <td>Stock</td> 
                                        <td>Sale&nbsp;price</td>
                                        
                                        <td>Buy price</td>

                                    @if(Auth::user()->role === 'admin')
                                         <td width="31px"> </td> 
                                        <td width="73px"> </td> 
                                        @endif
                                        
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($products as $product)

                                        <tr id="{{$product->id}}">
                                        <td><img src="{{ url('/uploads/products') }}/{{$product->featured_image}}" width="55px"></td>
                                          
                                           
                                              <td>{{$product->name }}
                                              <br>
                                                  <small style="font-size: 13px;">{{$product->name_bn }}</small>
                                              </td>
                                                <td>{{$product->unit_quantity }}{{$product->unit }}</td>
                                               <td>{{$product->stock_quantity }}</td>
                                               <td class="main_price"> &#2547; <span>{{$product->price - $product->discount }}</span>  </td>
                                           
                                           
                                            <td>
                                              @if(Auth::user()->role === 'admin')
                                            <input type="text" readonly class="form-control price"  style="width: 75px !important;"   value="{{$product->buy_price}}" />
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

       
		</script>   
    
@endsection
