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
                        <div class="panel-heading">Add New Delivery Boy</div>
                        <div class="panel-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }} <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                                </div>
                            @endif

                            @if(Auth::user()->role === 'admin')
                                {!! Form::open(['url' => 'ad/save-delivery-boy','class'=>'form-horizontal','enctype'=>'multipart/form-data','files'=>true ]) !!}

                            @endif


                            {{ csrf_field() }}

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right mt10">Delivery Boy Name</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right mt10">Phone</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="phone" required>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <label   class="col-md-4 col-form-label text-md-right"> </label>
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa  fa-save"></i> &nbsp;Submit
                                    </button>
                                </div>
                            </div>
                            {!! Form::close() !!}

                        </div>
                    </div>

                    <div class="panel panel-default simple-panel">
                        <div class="panel-heading">  Delivery Boy Lists</div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table id="example" class="table table-striped " style="font-size: 14px;">
                                    <thead>
                                    <tr class="text-uppercase">

                                        <td style="font-size: 13px;">Name</td>
                                        <td style="font-size: 13px;"> Phone    </td>
                                        <td  style="font-size: 13px;">Status  </td>
                                        <td>     </td>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach ($boys  as $boy)
                                        <tr>

                                            <td>{{$boy->name}}</td>
                                            <td>{{$boy->phone}}</td>

                                            <td  style="font-size: 12px;">
                                                @if($boy->status==1)
                                                    <span style="color: rgb(56, 142, 60);
background: rgb(200, 230, 201) none repeat scroll 0% 0%;
padding: 3px 6px;
border-radius: 2px;
border: 1px solid rgb(129, 199, 132);"> Active</span>
                                                @elseif($boy->status==0)
                                                    <span style="background:#feedef;color: #ef2f45;padding: 3px 6px;border: 1px solid #ef9a9a;border-radius: 2px;"> Inactive</span>
                                                @endif
                                            </td>
                                            <td class="text-center  "><a style="background:#fff9c4;color: #fbc02d;padding: 3px 6px;border: 1px solid #8080801c;border-radius: 2px;"   href="edit_delivery_boy/{{$boy->id}}" class="btn btn-sm"><i class="fa fa-edit"></i></a></td>
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
@endsection
