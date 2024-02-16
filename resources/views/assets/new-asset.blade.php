
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
                    <div class="panel-heading">New Asset  </div>
                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                                       {!! Form::open(['url' => 'ad/save-asset','class'=>'form-horizontal','enctype'=>'multipart/form-data','files'=>true ]) !!}
                                      

                         {{ csrf_field() }}
                           
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-right mt10">Asset Amount</label>
                            <div class="col-md-6">
                               <input type="number" class="form-control" name="amount" min="0" required="" />
                            </div>
                        </div>
                         
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right mt10">Asset Buy Date</label>
                                <div class="col-md-6">
                                      <div class="input-group date" data-provide="datepicker">
                  <input type="text" class="form-control" name="date"  required=""/>
                  <div class="input-group-addon">
                      <span class="glyphicon glyphicon-th"></span>
                  </div>
              </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right mt10">Asset Type</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="type" required="">
                                        <option value="">Select</option>
                                        <option value="Bottle">Bottle</option>
                                        <option value="Filter">Filter</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right mt10">Asset Quantity</label>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" name="quantity"  required=""/>
                                </div>
                            </div>
                              <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right mt10">Asset Purpose</label>
                                <div class="col-md-6">
                                    <textarea class="form-control" name="purpose" required=""></textarea>
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
                </div>
            </div>
        </div>
    </div>
        <div class="container-fluid  ">
            <div class="row justify-content-center">

                <div class="col-md-6 pull-right">
                    <div class="panel panel-info" style="margin-bottom:   15px;">
                        <div class="panel-body" style="padding: 16px !important;height: 36px;">
                            <div class="input-group  ">
                                <div class="date-show">
                                    <div class="pull-left">
                                        Total Asset Amount: <span></span></div> &nbsp;&nbsp;
                                    <div class="total_expense pull-right" style="color: #41c300;font-size: 15px;font-weight: bold;">{{$asset_amount->amount}}/=</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-12">

                    <div class="panel panel-default simple-panel">
                        <div class="panel-heading">
                              Asset List
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-bordered table-responsive inline-tbl" id="example">
                                <thead>
                                <tr>
                                    <th>
                                        SN
                                    </th>
                                    <th>
                                        Amount
                                    </th>
                                    <th>
                                        Quantity
                                    </th>
                                    <th>
                                        Type
                                    </th>
                                    <th>
                                        Buy Date
                                    </th>
                                    <th>
                                        Entry Date
                                    </th>
                                    <th>
                                        Purpose
                                    </th>
                                    <th>
                                        Added By
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($assets as $index => $asset)
                                    <tr>
                                        <td>
                                            {{$index+1}}
                                        </td>
                                        <td>
                                            &#2547; {{$asset->amount}}
                                        </td>
                                        <td>
                                            {{$asset->quantity}}
                                        </td>
                                        <td>
                                             {{$asset->type}}
                                        </td>
                                        <td>
                                            {{date('d M y', strtotime($asset->date))}}
                                        </td>
                                        <td>
                                            {{date('d M y', strtotime($asset->created_at))}}
                                        </td>

                                        <td>
                                            <small>
                                                {{$asset->purpose}}
                                            </small>
                                        </td>

                                            <td>
                                                <small>
                                                    <i class="fa fa-info-circle">
                                                    </i>
                                                    {{$asset->name}}
                                                </small>
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
@endsection