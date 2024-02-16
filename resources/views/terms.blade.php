@extends('layouts.app')

@section('content')
      @if(Auth::user()->role === 'admin')
    @include('layouts.admin-sidebar')
    @else
    @include('layouts.other-sidebar')  
    @endif

    <div class="content-area">
        <div class="container-fluid mt30">

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default simple-panel">
                        <div class="panel-heading">Update Terms & Condition</div>
                        <div class="panel-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
 
                          {!! Form::open(['url' => 'ad/update-terms','class'=>'form-vertical','enctype'=>'multipart/form-data','files'=>true ]) !!}
                         
                             {{ csrf_field() }}
                             
                            <div class="row"> 
                                <div class="col-md-12 mt10">
                                    <div class="form-group">
                                        <label class="col-form-label">Description</label>
                                        <textarea  name="description" class="form-control summernote" rows="15">{{$terms->description}}</textarea>
                                    </div>
                                </div>
                                 
                                <div class="col-md-12">
                                    <div class="form-group  mb-0">
                                        <button type="submit" class="btn btn-success">
                                            Update 
                                        </button>
                                    </div>
                                </div>
                            </div>

                            {!! Form::close() !!}

                        </div>
                    </div>
                </div>
                <div class="right-humberger-menu">

                </div>
            </div>
        </div>
    </div>
@endsection
