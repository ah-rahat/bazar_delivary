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
                        <div class="panel-heading">Deposit Money</div>
                        <div class="panel-body">
                            @if (session('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif
                                @if (session('error'))
                                    <div class="alert alert-danger" role="alert">
                                        {{ session('error') }}
                                    </div>
                                @endif

                            @if(Auth::user()->role === 'admin')
                                {!! Form::open(['url' => 'ad/save-deposit','class'=>'form-horizontal','enctype'=>'multipart/form-data','files'=>true ]) !!}
                            @endif


                            {{ csrf_field() }}
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-right mt10">Customer Name</label>
                                <div class="col-md-6">
                                    <select class="form-control selectpicker" data-show-subtext="true"
                                            name="customer_phone" data-live-search="true" required>
                                        <option value="" selected>
                                           Select Customer
                                        </option>
                                        @foreach($customers as $customer)
                                            <option value="{{$customer->phone}}">{{$customer->name}} -
                                                ( {{$customer->phone}} )
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-right mt10">Payment Method</label>
                                    <div class="col-md-6">
                                        <select class="form-control"
                                                name="payment_method"  required>
                                            <option value="" selected>
                                                Select Payment Method
                                            </option>
                                                <option value="Hand Cash">Hand Cash</option>
                                                <option value="B-kash">B-kash</option>
                                                <option value="Nagad">Nagad</option>
                                                <option value="Gift Money">Gift Money</option>
                                        </select>
                                    </div>
                                </div>

                            <div class="form-group row">
                                <label for="phone" class="col-md-4 col-form-label text-right mt10">Deposit
                                    Amount</label>
                                <div class="col-md-6">
                                    <input  class="form-control" name="deposit_amount" type="number" step="any"
                                           required=""/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <label class="col-md-4 col-form-label text-md-right"> </label>
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Submit
                                </button>
                            </div>
                        </div>
                        {!! Form::close() !!}

                    </div>

                    <div class="panel panel-default simple-panel">
                        <div class="panel-heading">Customer's' Deposit History</div>
                        <div class="panel-body">

                            <table class="table table-striped table-bordered table-responsive inline-tbl" id="example">
                                <thead>
                                <tr>
                                    <th>
                                        Customer Information
                                    </th>
                                    <th>
                                        Amount
                                    </th>
                                    <th>
                                        Payemnt Method
                                    </th>
                                    <th>Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($deposits as $deposit)
                                    <tr>
                                        <td>
                                            @foreach($customers as $customer)
                                                @if($customer->phone == $deposit->customer_phone)
                                                    {{$customer->name}} <small>({{$customer->phone}})</small>
                                                @endif
                                            @endforeach
                                            </td>
                                        <td>{{$deposit->amount}}</td>
                                        <td>{{$deposit->payment_method}}</td>
                                        <td>{{ date('j F, Y h:i A', strtotime($deposit->created_at)) }}</td>
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
