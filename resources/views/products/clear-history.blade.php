
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
                        <div class="panel-heading">Product History Clean & Unlock</div>
                        <div class="panel-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                                @if (session('error'))
                                    <div class="alert alert-danger" role="alert">
                                        {{ session('error') }}
                                    </div>
                                @endif


                            {!! Form::open(['url' => 'ad/stock-history-clean','class'=>'form-horizontal','enctype'=>'multipart/form-data','files'=>true ]) !!}



                            {{ csrf_field() }}

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right mt10">Product ID</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="product_id"   required="" />
                                </div>
                            </div>
                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-right mt10">Repeat Product ID</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="confirm" name="confirm_product_id"  autocomplete="off" required="" />
                                    </div>
                                </div>

                            <div class="form-group row mb-0">
                                <label   class="col-md-4 col-form-label text-md-right"> </label>
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-danger">
                                        Clean History
                                    </button>
                                </div>
                            </div>
                            {!! Form::close() !!}

                        </div>
                    </div>
                    <div class="panel panel-default simple-panel">
                        <div class="panel-heading">Product Lock As Real Stock</div>
                        <div class="panel-body">
                            @if (session('lockstatus'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('lockstatus') }}
                                </div>
                            @endif
                            @if (session('locerror'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('locerror') }}
                                </div>
                            @endif
                            {!! Form::open(['url' => 'ad/product-lock','class'=>'form-horizontal','enctype'=>'multipart/form-data','files'=>true ]) !!}

                            {{ csrf_field() }}

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right mt10">Product ID</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="product_id"   required="" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right mt10">Repeat Product ID</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="confirm" name="confirm_product_id"  autocomplete="off" required="" />
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <label   class="col-md-4 col-form-label text-md-right"> </label>
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Lock This  Product ID
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <script>
      $('#confirm').bind("cut copy paste",function(e) {
        e.preventDefault();
      });
    </script>
@endsection