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
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                </div>
                <div class="col-md-12">

                    <div class="panel panel-default simple-panel">
                        <div class="panel-heading">New Sms <a href="lists/print" target="_blank" class="btn btn-sm btn-info pull-right">SMS HISTORIES</a></div>
                        <div class="panel-body">

                                {!! Form::open(['url' => 'ad/save-sms','class'=>'form-horizontal','enctype'=>'multipart/form-data','files'=>true ]) !!}


                            {{ csrf_field() }}
                                <div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name" class="col-form-label">Message<b style="color: red">*</b></label>
                                            <textarea class="form-control" name="message" rows="4" required="" autofocus=""></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group  mb-0">
                                            <button type="submit" class="btn btn-success">
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            {!! Form::close() !!}


                        </div>
                    </div>
                </div>
                {!! Form::open(['url' => 'ad/save-numbers','class'=>'form-horizontal','enctype'=>'multipart/form-data','files'=>true ]) !!}


                {{ csrf_field() }}
                <div class="col-md-12">
                    <div class="panel panel-default simple-panel">
                        <div class="panel-heading">Sms List</div>
                        <div class="panel-body">
                            @foreach ($messages  as $message)
                            <div class="panel panel-success">
                            <div class="panel-body"><label><input class="cb-element message" name="message" value="{{$message->id}}" type="radio"> {{$message->text}}</label>
                            </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="panel panel-default simple-panel">
                        <div class="panel-heading">Customers List <button type="submit" class="btn btn-sm btn-info">CONFIRM & SEND SMS </button>
                            <label class="pull-right btn btn-default btn-sm" style="text-transform: uppercase;"><input type="checkbox" id="checkAll"> Check All</label>
                        </div>
                        <div class="panel-body">

                            <table  class="table table-striped table-bordered table-responsive inline-tbl">
                                <thead>
                                <tr>

                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Area</th>
                                    <th>Address</th>

                                </tr>
                                </thead>
                                <tbody>

                                @foreach ($users  as $user)
                                    <tr>
                                        <td><label><input type="checkbox" name="number"  id="{{$user->phone}}" class="cb-element" /> {{$user->name}} </label></td>
                                        <td>{{$user->phone}}</td>
                                        <td>{{$user->area}}</td>
                                        <td>{{$user->address}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>


    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>
        $("#checkAll").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });


    </script>
@endsection
@section('footerjs')
    <script>

        jQuery('input:radio').click(function () {

            let message = $(this).val();

            jQuery.ajax({
                type:'GET',
                url:'select-sms/',
                dataType: "json",
                data:{message:message},
                success:function(res) {
                    console.log(res);
                    Command: toastr["success"]("SMS Status Updated.");
                }
            });

        });


        jQuery('input:checkbox').click(function () {

            let status = $(this).is(":checked");
            let phone = $(this).attr('id');

           jQuery.ajax({
                    type:'GET',
                    url:'sms/'+phone+'/'+status,
                    dataType: "json",
                    data:'_token = <?php echo csrf_token() ?>',
                    success:function(res) {
                        console.log(res);
                        Command: toastr["success"]("SMS Status Updated.");
                    }
                });

        });




    </script>
@endsection