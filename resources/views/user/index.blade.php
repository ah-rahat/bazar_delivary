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
                <div class="panel-heading">Users List</div>
                <div class="panel-body">

                <table id="example" class="table table-striped table-bordered table-responsive inline-tbl">
                        <thead>
                        <tr>
                            {{--<td>SN</td>--}}
                            <th>Name</th>
                            <th>Role</th>
                            <th>Phone</th>
                            <th>Date</th>
                            <th>Email</th>

                            <th width="55px">   </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($users  as $user)
                        <tr>
                            <td>{{$user->name}}</td>
                            <td style="text-transform: capitalize;">
                            @if($user->role==3)
                            Customer
                            @else
                            <span class="green-color">{{$user->role}}</span>
                            @endif
                            </td>
                            <td>{{$user->phone}}</td>
                            <td style="word-break: break-all;">{{ date('M d h:i a', strtotime($user->created_at)) }}</td>
                            <td>{{$user->email}}</td>

                            <td class="text-center"><a class="btn btn-warning btn-sm" href="users/{{$user->id}}"><i class="fa fa-pencil"></i></a></td>
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
