@extends('layouts.app') @section('content') @if(Auth::user()->role === 'admin') @include('layouts.admin-sidebar') @else @include('layouts.other-sidebar') @endif
<div class="content-area">
    <div class="container-fluid mt30">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="panel panel-default simple-panel">
                    <div class="panel-heading">
                        Affiliate Users List
                    </div>
                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <table class="table table-striped table-bordered table-responsive inline-tbl" id="example">
                            <thead>
                            <tr>
                                <th>
                                    SN
                                </th>
                                <th>
                                    Marketer
                                </th>
                                <th>
                                   Customer Phone
                                </th>
                                <th>
                                   Created Date
                                </th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($users as $index => $user)
                                <tr>
                                    <td>
                                        {{$index+1}}
                                    </td>
                                    <td>
                                        {{$user->name}} {{$user->phone}}
                                    </td>
                                    <td>
                                         {{$user->customer_phone}}
                                    </td>
                                    <td>
                                        {{date('d M y', strtotime($user->created_at))}}
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