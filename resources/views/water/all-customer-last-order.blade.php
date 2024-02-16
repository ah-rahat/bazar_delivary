@extends('layouts.app')

@section('content')
    @if(Auth::user()->role === 'admin')
        @include('layouts.admin-sidebar')
    @else
        @include('layouts.other-sidebar')
    @endif
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <div class="content-area" id="apps">
        <div class="container-fluid mt30">
            <div class="row">

                <div class="col-md-12 mt10">
                    <div class="panel panel-success">
                        <div class="panel-heading">Last Order Customers History</div>
                        <div class="panel-body">
                            <div>
                                <table  class="table table-striped ">
                                    <thead>
                                    <tr>
                                        <td>Phone</td>
                                        <td>Name</td>
                                        <td>Area</td>
                                        <td>Address</td>
                                        <td>Last.Order</td>

                                    </tr>
                                    </thead>
                                    <tbody id="feedback">

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
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <style>
        .steps-bar span.selected{
            background: #f273a9;
            color: #fff;
            font-weight: normal;
        }
        .steps-bar span.selected label{
            font-weight: normal;
        }
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.20/lodash.min.js">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.21/dist/vue.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js">
    </script>
    <script type="text/javascript">

        var app = new Vue({
            el: '#apps',
            delimiters: ['!{', '}!'],
            data: {
                customers: null,

            },
            created: function () {
                this.customersData();
            },
            methods: {
                customersData: function () {

                    let vm = this;

                    axios.get('http://mmmethod.net/shop/api/all-inactive-customer-lists')
                        .then(function (response) {
                            // handle success
                            //let customers =  response.data;
                            console.log(response.data);
                            let today = new Date().toISOString().slice(0, 10)
                            var filtered = response.data.filter(function (el) {
                                return el != null;
                            });
                            //console.log(filtered);
                            let customers =  filtered;

                            customers.forEach( function ( element){
                                const startDate  =  moment(element.created_at).format('y-M-D');
                                const endDate    = today;
                                const diffInMs   =  new Date(endDate) -  new Date(startDate);
                                const diffInDays = diffInMs / (1000 * 60 * 60 * 24);
                              if(diffInDays > 30){
                                $('#feedback').append('<tr><td>' + element.phone + '</td><td>' + element.name + '</td><td>' + element.area + '</td><td>'+ element.address +'</td><td>'+ diffInDays +' Days <td></tr>');
                              }
                              } );


                        })
                        .catch(function (error) {
                            // handle error
                            console.log(error);
                        });
                }

            }
        });
    </script>

@endsection
