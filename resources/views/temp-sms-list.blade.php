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
                        <div class="panel-heading">Customers List For send SMS <button type="submit" class="btn btn-sm btn-info pull-right">CONFIRM & SEND SMS </button>

                        </div>
                        <div class="panel-body">

                            <table  class="table table-striped table-bordered table-responsive inline-tbl">
                                <thead>
                                <tr>

                                    <th width="50px">SN</th>
                                    <th>Phone</th>
                                    <th>Message</th>

                                </tr>
                                </thead>
                                <tbody>

                                @foreach ($users  as $user )
                                    <tr>
                                        <td>{{ $loop->index+1 }}</td>
                                        <td> {{ $user->phone}}</td>
                                        <td>{{$user->text}}</td>
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