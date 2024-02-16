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
                        <div class="panel-heading">Customer's'Remaining Deposit Amount</div>
                        <div class="panel-body">

                            <table class="table table-striped table-bordered table-responsive inline-tbl" id="example">
                                <thead>
                                <tr>
                                    <th>
                                        Customer Name
                                    </th>
                                    <th>
                                        Customer Phone
                                    </th>
                                    <th>
                                       Deposit Amount
                                    </th>
                                    <th>
                                        Purchase Amount
                                    </th>
                                    <th>
                                        Remaining Deposit
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($customers_deposits as $deposit)
                                    <tr>
                                        <td>
                                            @foreach($users as $user)
                                                @if($user->phone == $deposit->customer_phone)
                                                    {{$user->name}}
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            {{$deposit->customer_phone}}
                                        </td>
                                        <td style="color: #e91e63;font-weight: 600;">&#2547;{{$deposit->total_deposits}}</td>
                                        <td style="color: #FF9800;font-weight: 600;">
                                            @foreach($customers_purchase as $purchase)
                                                @if($purchase->customer_phone == $deposit->customer_phone)
                                                    &#2547;{{$purchase->amount}}

                                                @endif
                                            @endforeach
                                        </td>
                                        <td style="color: #41c300 !important;font-weight: 600;">
                                            @foreach($customers_purchase as $purchase)
                                            @if($purchase->customer_phone == $deposit->customer_phone)
                                                    &#2547;{{ $deposit->total_deposits - $purchase->amount}}
                                               
                                                @endif
                                            @endforeach
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
