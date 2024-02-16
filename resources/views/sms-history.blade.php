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
                        <div class="panel-heading">Customers List

                        </div>
                        <div class="panel-body">

                            <table  class="table table-striped table-bordered table-responsive inline-tbl">
                                <thead>
                                <tr>

                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Area</th>
                                    <th>SMS</th>
                                    <th>Date</th>

                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($users  as $user)
                                    <tr>

                                        <td>{{$user->name}} </td>
                                        <td>{{$user->phone}}</td>
                                        <td>{{$user->area}}</td>
                                        <td>SMS</td>
                                        <td>SMS</td>

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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>
        // $("#checkAll").click(function () {
        //     $('input:checkbox').not(this).prop('checked', this.checked);
        // });


    </script>
@endsection
