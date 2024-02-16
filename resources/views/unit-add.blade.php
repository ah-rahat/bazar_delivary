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
            <div class="col-md-12">
                <div class="panel panel-default simple-panel">
                    <div class="panel-heading">Add New Unit</div>
                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }} <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                            </div>
                        @endif
                        
                                                
                        @if(Auth::user()->role === 'admin')
                       
                        {!! Form::open(['url' => 'ad/save_unit','class'=>'form-horizontal','enctype'=>'multipart/form-data','files'=>true ]) !!}
   
                        @elseif(Auth::user()->role === 'manager')                      
                        
                        {!! Form::open(['url' => 'pm/save_unit','class'=>'form-horizontal','enctype'=>'multipart/form-data','files'=>true ]) !!}
   
                        @endif 
                        
                      
                        
                        {{ csrf_field() }}

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-right mt10">Unit Name (EN)</label>
                            <div class="col-md-6">
                               <input type="text" class="form-control" name="unit_name" required>
                            </div>
                        </div>
                          
                        <div class="form-group row mb-0">
                            <label   class="col-md-4 col-form-label text-md-right"> </label>
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                   <i class="fa  fa-save"></i> &nbsp;Add Unit
                                </button>
                            </div>
                        </div>
                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
