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
                        <div class="panel-heading">Refer Customer's</div>
                        <div class="panel-body">

                            <table class="table table-striped table-bordered table-responsive inline-tbl" id="example">
                                <thead>
                                <tr>
                                    <th>
                                        Refer By
                                    </th>
                                    <th>
                                        Date
                                    </th>
                                    <th>
                                       Refer Customer Phone
                                    </th>

                                    <th>
                                        Gift Amount
                                    </th>
                                    <th>
                                        Comment
                                    </th>
                                    <th>
                                        Status
                                    </th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($customer_references as $user)
                                    <tr>
                                        <td>
                                            @foreach($customers as $customer)
                                                @if($customer->id == $user->user_id)
                                                    {{$customer->name}} - <small> {{$customer->phone}}</small>
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>{{ date('j M, Y h:i A', strtotime($user->created_at)) }}</td>
                                        <td>
                                            {{$user->referer_phone}}
                                        </td>
                                        <td style="color: #e91e63;font-weight: 600;">&#2547;{{$user->gift_amount}}</td>
                                        <td>
                                            {{$user->comment}}
                                        </td>
                                        <td>
                                            {{$user->status}}
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
