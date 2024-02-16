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
                        <div class="panel-heading">Customer's' Deposit Request</div>
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
                                    <th>Transaction ID</th>
                                    <th>Message</th>
                                    <th>Date</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($deposits as $deposit)
                                    <tr>
                                        <td>
                                            @foreach($customers as $customer)
                                                @if($customer->id == $deposit->customer_id)
                                                    {{$customer->name}} <small>({{$customer->phone}})</small>
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>{{$deposit->amount}}</td>
                                        <td>{{$deposit->payment_method}}</td>
                                        <td>{{$deposit->transaction_id}}</td>
                                        <td>{{$deposit->requestMessage}}</td>
                                        <td>{{ date('j F, Y h:i A', strtotime($deposit->created_at)) }}</td>
                                        <td>
                                            @if($deposit->status == 0)
                                            <a href="deposit-request-list/{{$deposit->id}}" target="_blank" class="btn btn-sm btn-success"><i class="fa fa-check"></i></a></td>
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
@endsection
@section('footerjs')

@endsection
