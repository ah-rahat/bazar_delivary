@extends('layouts.app')

@section('content')
    @if(Auth::user()->role === 'admin')
        @include('layouts.admin-sidebar')
    @else
        @include('layouts.other-sidebar')
    @endif
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <div class="content-area">
        <div class="container-fluid mt30">
            <div class="row">

                <div class="col-md-12 mt10">
                    <div class="panel panel-success">
                        <div class="panel-heading">Disable Customers List</div>
                        <div class="panel-body">
                            <div>
                                <table id="example" class="table table-striped ">
                                    <thead>
                                    <tr>
                                        <td>Name</td>
                                        <td>Phone</td>
                                        <td>Address</td>
                                        <td></td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($customers as $customer)

                                        <tr>
                                            <td>

                                                @if(Auth::user()->role === 'admin')
                                                    <a style="color: #4caf50 !important"
                                                       href="/web/ad/water_customer/{{$customer->id}}">
                                                        {{$customer->name}}<i class="fa fa-pencil"></i></a>
                                                @elseif(Auth::user()->role === 'manager')
                                                    <a style="color: #4caf50 !important"
                                                       href="/web/pm/water_customer/{{$customer->id}}">
                                                        {{$customer->name}}<i class="fa fa-pencil"></i></a>
                                                @endif


                                            </td>
                                            <td>{{$customer->phone}}</td>
                                            <td>{{$customer->address}}</td>

                                            <td>

                                                @if(Auth::user()->role === 'admin')
                                                    <a class="btn-sm btn-warning pull-right"
                                                       href="/web/ad/waters/{{$customer->id}}"><i class="fa fa-eye"></i></a>

                                                @elseif(Auth::user()->role === 'manager')

                                                    <a class="btn-sm btn-warning pull-right"
                                                       href="/web/pm/waters/{{$customer->id}}"><i class="fa fa-eye"></i></a>
                                                @elseif(Auth::user()->role === 'author')

                                                    <a class="btn-sm btn-warning pull-right"
                                                       href="/web/au/waters/{{$customer->id}}"><i class="fa fa-eye"></i></a>

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
                <div class="right-humberger-menu">

                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>
    <style>
        .steps-bar span.selected {
            background: #f273a9;
            color: #fff;
            font-weight: normal;
        }

        .steps-bar span.selected label {
            font-weight: normal;
        }
    </style>


@endsection
