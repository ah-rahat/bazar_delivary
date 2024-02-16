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
                        <div class="panel-heading">Medicine List</div>
                        <div class="panel-body">
                        <div class="text-right">
                         
                        @if(Auth::user()->role === 'admin')
                        {!! Form::open(['url' => 'ad/search-medicines','class'=>'form-vertical','enctype'=>'multipart/form-data','files'=>true ]) !!}
                        @elseif(Auth::user()->role === 'manager')                      
                        {!! Form::open(['url' => 'pm/search-medicines','class'=>'form-vertical','enctype'=>'multipart/form-data','files'=>true ]) !!}
                            @elseif(Auth::user()->role === 'author')
                                {!! Form::open(['url' => 'au/search-medicines','class'=>'form-vertical','enctype'=>'multipart/form-data','files'=>true ]) !!}

                            @endif
                       
                        {{ csrf_field() }}
                        
                         <div class="input-group"> <input class="form-control" aria-label="Text input with multiple buttons" name="id"> <div class="input-group-btn">   <button type="submit" class="btn btn-default">Search</button> </div> </div>
                         {!! Form::close() !!}
                        </div>
                            <div>
                                <table class="table table-striped ">
                                    <thead>
                                    <tr>
                                        <td>DAR</td> 
                                        <td>name</td>
                                        <td>Generic Name</td> 
                                        <td>price</td>
                                         <td>discount</td>
                                        <td>quantity</td>
                                         <td>status</td> 
                                        
                                        <td>F.Image</td>
                                        <td width="80px"> </td>
                                        
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($products as $product)
  
                                        <tr>
                                          <td>{{$product->DAR}}</td>
                                            <td>{{$product->name}}</td>
                                            <td>{{$product->generic_name}}</td>
                                            <td>{{$product->price}}</td>
                                            <td>{{$product->discount}}</td>
                                            <td>{{$product->unit_quantity}} {{$product->unit}}</td> 
                                             <td>
                                             @if($product->status==1)
                                             <span style="color: #388e3c;background: #c8e6c9;padding: 3px 6px;border-radius: 2px;
border: 1px solid #81c784;">Active</span>
                                             @else
                                              <span style="background:#feedef;color: #ef2f45;padding: 3px 6px;border: 1px solid #ef9a9a;border-radius: 2px;">InActive</span>
                                             @endif
                                             </td>
                                            <td><img src="{{ url('/uploads/products') }}/{{$product->featured_image}}" width="55px"></td>
                                           
                                            <td >
{{--                                                @if(Auth::user()->role === 'admin')--}}
                                            <!--
                                                <a class="btn-sm btn-danger pull-right ml10" href="product/delete/{{$product->id}}"><i class="fa fa-trash"></i></a>
                                                -->

                                                <a class="btn-sm btn-warning pull-right" href="medicine/{{$product->id}}"><i class="fa fa-edit"></i></a>
{{--                                                @endif--}}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                        <div class="text-right">
                         @if($searchvalue!='')
                         
                         @else
                        {{  $products  }}
                         @endif
                       </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
