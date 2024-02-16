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
{{--            !{customers}!--}}
            <div class="row">
                <div class="col-md-12 mt10">
                    <div class="panel panel-success">
                        <div class="panel-heading">Water Last Orders Customers List</div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table  class="table table-striped ">
                                    <thead>
                                    <tr>
                                        <td>Phone</td>
                                        <td>Name</td>
                                        <td>Area</td>
                                        <td>Address</td>
                                        <td>Last.Order</td>
                                        <td>Comment</td>
                                    </tr>
                                    </thead>
                                    <tbody id="feedback">
{{--                                    <tr v-for="(customer, i) in customers">--}}
{{--<td>!{ i+1 }!</td>--}}
{{--<td>!{ customer.name }!</td>--}}
{{--<td>!{ customer.phone }!</td>--}}
{{--                                    </tr>--}}

{{--                                    @foreach($customers as $dt)--}}
{{--                                        <tr>--}}
{{--                                            <td>{{$dt->name}}</td>--}}

{{--                                        </tr>--}}
{{--                                    @endforeach--}}

{{--                                    @foreach($customers as $dt)--}}
{{--                                        <tr>--}}
{{--                                            <td>{{$dt->name}}</td>--}}
{{--                                            <td>{{$dt->name}}</td>--}}
{{--                                            <td>--}}
{{--                                                @foreach($locations as $location)--}}
{{--                                                    @if($location->id === $dt->area_id )--}}
{{--                                                        {{$location->location_name_bn}}--}}
{{--                                                    @endif--}}

{{--                                                @endforeach--}}
{{--                                            </td>--}}
{{--                                            <td>{{$dt->address}}</td>--}}
{{--                                            <td>--}}

{{--                                                {{$dt->created_at}}--}}
{{--                                            </td>--}}
{{--                                            <td><textarea class="form-control">{{$dt->comment}}</textarea></td>--}}
{{--                                        </tr>--}}
{{--                                    @endforeach--}}


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
                customers: [],

            },
            created: function () {
             this.customersData();
            },
            methods: {

                customersData: function () {

                    let vm = this;

                    axios.get('http://mmmethod.net/shop/api/inactive-customer-lists')
                        .then(function (response) {
                            // handle success

                            //console.log(response.data);

                            var filtered = response.data.filter(function (el) {
                                return el != null;
                            });
                            console.log(filtered);
                            let customers =  filtered;
                            //vm.customers= filtered;
                            let today = new Date().toISOString().slice(0, 10)
                            // response.data.map(function(value, key) {
                            //     list.push(value);
                            // });

                            customers.forEach( function ( element){

                                const startDate  =  moment(element.created_at).format('y-M-D');
                                const endDate    = today;
                                const diffInMs   =  new Date(endDate) -  new Date(startDate);
                                const diffInDays = diffInMs / (1000 * 60 * 60 * 24);

                                //vm.customers.push({'days':diffInDays,'phone':element.phone});

                            $('#feedback').append('<tr   class="'+element.phone+'"><td>' + element.phone + '</td><td>' + element.name + '</td><td>' + element.area + '</td><td>'+ element.address +'</td><td>'+ diffInDays +' Days </td> <td><textarea class="form-control"  style="width: 150px;"   placeholder="Comments">'+ element.comment   +'</textarea> <button class="show btn btn-sm"  id="'+element.phone+'">Save</button> </td>  </tr>');

                            } );


                        })
                        .catch(function (error) {
                            // handle error

                        });
                }

            }
        });
        $(document).on("click",".show", function () {

        let phone =  $(this).attr('id');
         var comment = $('.'+phone + ' textarea').val();


         $.ajax({
             type:'GET',
             url:'water-customer-comment/'+phone+'/'+comment,
             dataType: "json",
             data:'_token = <?php echo csrf_token() ?>',
             success:function(res) {
                 console.log(res);
                 Command: toastr["info"]("Comment added");

             }
         });
        });

    </script>

@endsection
