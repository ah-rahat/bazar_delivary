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
                <div class="col-md-12 mt30">
                    <div class="panel panel-success">
                        <div class="panel-heading">Expire Products List</div>
                        <div class="panel-body">
                            <div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table stocklising">

                                                <thead>

                                                <tr>
                                                    <td class="comment">
                                                        Name
                                                    </td>
                                                    {{--                                                    <td class="comment">--}}
                                                    {{--                                                        Quantity--}}
                                                    {{--                                                    </td>--}}

                                                    <td class="comment">
                                                        Date
                                                    </td>

                                                </tr>
                                                </thead>
                                                <tbody id="expire_list">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footerjs')

    <script>


        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        jQuery.ajax({
            type: 'GET',
            url: '/web/api/shop/expire-products',
            dataType: "json",
            data: '_token = <?php echo csrf_token() ?>',
            success: function (data) {

                var table = jQuery("#expire_list");
                console.log(data);
                jQuery.each(data.data, function (key, value) {

                        // alert(value.name);
                        table.append("<tr>" +
                            "<td><a style='color: #000;' target='_blank' href="+'/web/shop/products/'+value.product_id+">" + value.name + ' '+  value.unit_quantity + ' '+ value.unit +"</a></td>" +
                            // "<td>" + value.quantity + "</td>" +
                            "<td>" + value.expire_date + "</td>");

                });

                //console.log(data);


            }
        });


    </script>


@endsection
