
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
                        <div class="panel-heading">New Due Customer  </div>
                        <div class="panel-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                                @if(Auth::user()->role === 'admin')
                                    {!! Form::open(['url' => 'ad/add-due-customer','class'=>'form-horizontal','enctype'=>'multipart/form-data','files'=>true ]) !!}

                                @elseif(Auth::user()->role === 'manager')
                                    {!! Form::open(['url' => 'pm/add-due-customer','class'=>'form-horizontal','enctype'=>'multipart/form-data','files'=>true ]) !!}

                                @endif


                            {{ csrf_field() }}

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right mt10">Customer Name</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name" required="" />
                                </div>
                            </div>
                                <div class="form-group row">
                                    <label for="phone" class="col-md-4 col-form-label text-right mt10">Customer Phone</label>
                                    <div class="col-md-6">
                                        <input type="text"  class="form-control" name="phone" required="" />
                                    </div>
                                </div>

                            </div>


                            <div class="form-group row mb-0">
                                <label   class="col-md-4 col-form-label text-md-right"> </label>
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Submit
                                    </button>
                                </div>
                            </div>
                            {!! Form::close() !!}

                        </div>

                    <div class="panel panel-default simple-panel">
                        <div class="panel-heading">Due Customer's' <span class="pull-right" style="font-size: 14px;font-weight: 600;color: #e61459;">DUE AMOUNT : {{$total_dues - $total_paid}}</span></div>
                        <div class="panel-body">

                            <table class="table table-striped table-bordered table-responsive inline-tbl" id="example">
                                    <thead>
                                    <tr>
                                        <th>
                                            Name
                                        </th>
                                        <th>
                                            Phone
                                        </th>
                                        <th>

                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($due_customers as $due_customer)
                                    <tr>
                                        <td>
                                            {{$due_customer->name}}
                                        </td>
                                        <td>
                                            {{$due_customer->phone}}
                                        </td>
                                        <td class="text-center">
                                            @if(Auth::user()->role === 'admin')
                                                <a style="color: rgb(56, 142, 60);
background: rgb(200, 230, 201) none repeat scroll 0% 0%;
padding: 3px 6px;
border-radius: 2px;
border: 1px solid rgb(129, 199, 132);" title="Order Details" target="_blank" href="https://gopalganjbazar.com/web/ad/due-customer/{{$due_customer->id}}" class="btn btn-sm"><i class="fa fa-rocket"></i></a>

                                            @elseif(Auth::user()->role === 'manager')
                                                <a style="color: rgb(56, 142, 60);
background: rgb(200, 230, 201) none repeat scroll 0% 0%;
padding: 3px 6px;
border-radius: 2px;
border: 1px solid rgb(129, 199, 132);" title="Order Details" target="_blank" href="https://gopalganjbazar.com/web/pm/due-customer/{{$due_customer->id}}" class="btn btn-sm"><i class="fa fa-rocket"></i></a>

                                            @endif
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
@endsection
@section('footerjs')

@endsection