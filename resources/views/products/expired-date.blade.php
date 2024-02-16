@extends('layouts.app')
@section('content')
    @if(Auth::user()->role === 'admin')
        @include('layouts.admin-sidebar')
    @else
        @include('layouts.other-sidebar')
    @endif
    <div class="content-area" id="apps">

        <div class="container-fluid mt30">
            <div class="row justify-content-center">
                <div class="col-md-12 mt30">
                    <div class="panel panel-success">
                        <div class="panel-heading">Products Expired Date Time</div>
                        <div class="panel-body">
                            <div>
                                <table id="example"  class="table table-striped ">
                                    <thead>
                                    <tr>
                                        <td>Photo</td>
                                        <td>Name</td>
                                        <td width="200px">Expired Date</td>
                                        <td></td>
                                    </tr>
                                    </thead>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.20/lodash.min.js">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.21/dist/vue.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js">
    </script>

    <script src="https://gopalganjbazar.com/web/js/jquery.dataTables.min.js"></script>


    <script>

        jQuery('body').on('click', '#colapsebtn', function (e) {
            jQuery(".left-area").toggleClass("onofme");
        });
        jQuery(function(){

            var current = window.location;

            jQuery('.sidebar li a').each(function(){
                var $this = $(this);
                // if the current path is like this link, make it active
                if($this.attr('href')== current){
                    $this.addClass('active');
                    jQuery(this).parent().parent().addClass('in');
                    jQuery(this).parent().parent().parent().addClass('top');
                }
            });

            // $(".nav-link.active").closest('collapse').addClass('in');
            //$(".nav-link.active").parents('collapse').addClass('in');
        });
        jQuery(document).ready(function() {
            jQuery.noConflict();
                jQuery('#example').dataTable(
                {
                    "order": []
                }
            );

            ///$('#datatable-keytable').DataTable( { keys: true } );
            // $('#datatable-responsive').DataTable();

        } );

    </script>


    <script type="text/javascript">
        var app = new Vue({
            el: '#apps',
            delimiters: ['!{', '}!'],
            data: {
                products: [],
            },
            created: function () {
                this.customersData();
            },
            methods: {
                customersData: function () {
                    let vm = this;
                    $(() => {
                        var table = $("#example tbody");

                        $.ajax({
                            url: 'https://gopalganjbazar.com/web/api/product-expires-list',
                            method: "GET",
                            xhrFields: {
                                withCredentials: true
                            },
                            success: function (response) {

                                $.each(response.data, function (b) {
                                    console.log(b);
                                    table.append("<tr><td>"+b.product_id+"</td>" +
                                        "<td>"+b.product_id+"</td>"+
                                        "<td>" + b.product_id + "</td>" +
                                        "<td>" + b.product_id + "</td>");
                                });

                                $("#example").DataTable();
                            }
                        });
                    });
                    axios.get('https://gopalganjbazar.com/web/api/product-expires-list')
                        .then(function (response) {
                           //console.log(response.data.data);
                          // vm.products = response.data.data;

                        })
                        .catch(function (error) {
                            // handle error
                        });
                }
            }
        });
    </script>

@endsection
